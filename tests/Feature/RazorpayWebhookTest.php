<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The Razorpay payment.captured webhook.
 *
 * This is the safety net for a host who pays and then closes the tab before
 * being redirected back - verify() never runs, so without this the money is
 * taken and the listing stays private.
 *
 * The route is public and unauthenticated, so the HMAC signature over the
 * raw body is its only protection. These tests exercise that boundary as
 * much as the happy path.
 */
class RazorpayWebhookTest extends TestCase
{
    use RefreshDatabase;

    private const SECRET = 'test_webhook_secret';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'razorpay.key_id'         => 'rzp_test_key',
            'razorpay.key_secret'     => 'test_secret',
            'razorpay.webhook_secret' => self::SECRET,
        ]);
    }

    /** A listing that is approved but not yet paid for. */
    private function unpaidProperty(): Property
    {
        return Property::factory()->create([
            'listing_status'      => Property::STATUS_APPROVED,
            'is_visible'          => false,
            'subscription_expiry' => null,
        ]);
    }

    /** @param array<string, mixed> $overrides */
    private function payload(Property $property, int $duration = 90, array $overrides = []): array
    {
        return array_replace_recursive([
            'event'   => 'payment.captured',
            'payload' => [
                'payment' => [
                    'entity' => [
                        'id'     => 'pay_TEST'.$property->id,
                        'amount' => Transaction::DURATION_PRICES[$duration] * 100,
                        'notes'  => [
                            'property_id'   => (string) $property->id,
                            'duration_days' => (string) $duration,
                        ],
                    ],
                ],
            ],
        ], $overrides);
    }

    /** @param array<string, mixed> $payload */
    private function send(array $payload, ?string $signature = null): \Illuminate\Testing\TestResponse
    {
        $body = json_encode($payload);

        return $this->call(
            'POST',
            '/webhooks/razorpay',
            [], [], [],
            [
                'CONTENT_TYPE'             => 'application/json',
                'HTTP_X_RAZORPAY_SIGNATURE' => $signature ?? hash_hmac('sha256', $body, self::SECRET),
            ],
            $body
        );
    }

    public function test_a_signed_capture_publishes_the_listing(): void
    {
        $property = $this->unpaidProperty();

        $this->send($this->payload($property, 90))->assertOk();

        $property->refresh();
        $this->assertTrue($property->is_visible);
        $this->assertNotNull($property->subscription_expiry);
        $this->assertSame(90, (int) now()->startOfDay()->diffInDays($property->subscription_expiry));
    }

    public function test_it_records_a_successful_transaction(): void
    {
        $property = $this->unpaidProperty();

        $this->send($this->payload($property, 30))->assertOk();

        $txn = Transaction::where('gateway_payment_id', 'pay_TEST'.$property->id)->firstOrFail();
        $this->assertSame(Transaction::STATUS_SUCCESS, $txn->payment_status);
        $this->assertSame(30, $txn->pack_duration_days);
        $this->assertSame('799.00', $txn->amount_paid);
        $this->assertNotNull($txn->paid_at);
    }

    /**
     * The whole reason the webhook exists: no transaction row exists yet,
     * because the host never came back for verify() to create one.
     */
    public function test_it_publishes_even_when_no_transaction_row_exists(): void
    {
        $property = $this->unpaidProperty();
        $this->assertSame(0, Transaction::count());

        $this->send($this->payload($property, 365))->assertOk();

        $this->assertTrue($property->refresh()->is_visible);
        $this->assertSame(1, Transaction::count());
    }

    public function test_an_invalid_signature_is_rejected(): void
    {
        $property = $this->unpaidProperty();

        $this->send($this->payload($property), 'not-a-real-signature')
            ->assertStatus(400);

        $this->assertFalse($property->refresh()->is_visible);
        $this->assertSame(0, Transaction::count());
    }

    public function test_a_missing_signature_is_rejected(): void
    {
        $property = $this->unpaidProperty();

        $this->send($this->payload($property), '')->assertStatus(400);

        $this->assertFalse($property->refresh()->is_visible);
    }

    /**
     * A tampered body must fail even though the signature itself is a valid
     * HMAC of the ORIGINAL body - this is what stops someone replaying a real
     * callback with the property_id swapped.
     */
    public function test_a_tampered_body_is_rejected(): void
    {
        $victim = $this->unpaidProperty();
        $attacker = $this->unpaidProperty();

        $original = $this->payload($victim);
        $signature = hash_hmac('sha256', json_encode($original), self::SECRET);

        $tampered = $original;
        $tampered['payload']['payment']['entity']['notes']['property_id'] = (string) $attacker->id;

        $this->send($tampered, $signature)->assertStatus(400);

        $this->assertFalse($attacker->refresh()->is_visible);
    }

    /**
     * Razorpay retries, and verify() may have already run. Extending the
     * subscription twice for one payment would be giving away time.
     */
    public function test_a_repeated_delivery_does_not_extend_twice(): void
    {
        $property = $this->unpaidProperty();

        $this->send($this->payload($property, 90))->assertOk();
        $firstExpiry = $property->refresh()->subscription_expiry;

        $this->send($this->payload($property, 90))->assertOk();

        $this->assertTrue($firstExpiry->equalTo($property->refresh()->subscription_expiry));
        $this->assertSame(1, Transaction::count());
    }

    public function test_an_amount_that_does_not_match_the_plan_is_refused(): void
    {
        $property = $this->unpaidProperty();

        // Claims the 365-day plan but paid the 30-day price.
        $payload = $this->payload($property, 365);
        $payload['payload']['payment']['entity']['amount'] = Transaction::PRICE_30 * 100;

        $this->send($payload)->assertOk();   // 200 so Razorpay stops retrying

        $this->assertFalse($property->refresh()->is_visible);
        $this->assertSame(0, Transaction::count());
    }

    public function test_other_events_are_acknowledged_and_ignored(): void
    {
        $property = $this->unpaidProperty();

        $payload = $this->payload($property);
        $payload['event'] = 'payment.failed';

        $this->send($payload)->assertOk()->assertJson(['status' => 'ignored']);

        $this->assertFalse($property->refresh()->is_visible);
    }

    public function test_an_unknown_property_is_acknowledged_not_retried(): void
    {
        $property = $this->unpaidProperty();
        $payload = $this->payload($property);
        $payload['payload']['payment']['entity']['notes']['property_id'] = '999999';

        $this->send($payload)->assertOk();

        $this->assertSame(0, Transaction::count());
    }

    public function test_the_route_is_exempt_from_csrf(): void
    {
        // Reaching a 400 (signature check) rather than a 419 proves the CSRF
        // middleware let the request through.
        $this->send($this->payload($this->unpaidProperty()), 'bad')
            ->assertStatus(400);
    }
}
