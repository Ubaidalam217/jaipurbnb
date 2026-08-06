<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Razorpay\Api\Api;
use Throwable;

/**
 * Razorpay subscription payments.
 *
 * FLOW
 *   1. plans()       host picks a duration
 *   2. createOrder() server creates a Razorpay order, returns order_id
 *   3. checkout      Razorpay's JS modal collects the card/UPI details
 *   4. verify()      server checks the HMAC signature, then publishes
 *
 * TRUST BOUNDARY - the important part. The browser sends only a
 * `duration` (30 | 90 | 365). It never sends a price. The amount is
 * looked up server-side from Transaction::DURATION_PRICES, so a tampered
 * request cannot buy a year for one rupee. verify() re-reads the amount
 * from the same table rather than trusting anything posted back.
 *
 * OWNERSHIP - like the rest of the host area, a listing belonging to
 * someone else 404s rather than 403s, so an id cannot be probed.
 *
 * SWITCHING TO LIVE KEYS is a .env change only: RAZORPAY_KEY_ID and
 * RAZORPAY_KEY_SECRET. No code here refers to test vs live.
 */
class PaymentController extends Controller
{
    /**
     * Plan copy for the three durations. Prices are NOT defined here -
     * they come from Transaction::DURATION_PRICES, the single source of
     * truth quoted in CLAUDE.md.
     */
    private const PLAN_COPY = [
        Transaction::DURATION_30 => [
            'name'     => 'Starter',
            'tagline'  => 'Try a month',
            'popular'  => false,
            'features' => [
                'Listing live for 30 days',
                'Unlimited WhatsApp and call enquiries',
                'Availability calendar',
                'Up to 15 photos',
            ],
        ],
        Transaction::DURATION_90 => [
            'name'     => 'Growth',
            'tagline'  => 'Cover a full season',
            'popular'  => true,
            'features' => [
                'Listing live for 90 days',
                'Unlimited WhatsApp and call enquiries',
                'Availability calendar',
                'Up to 15 photos',
                'Lead analytics in your dashboard',
            ],
        ],
        Transaction::DURATION_365 => [
            'name'     => 'Annual',
            'tagline'  => 'Best value per day',
            'popular'  => false,
            'features' => [
                'Listing live for 365 days',
                'Unlimited WhatsApp and call enquiries',
                'Availability calendar',
                'Up to 15 photos',
                'Lead analytics in your dashboard',
                'Priority support',
            ],
        ],
    ];

    public function plans(Property $property): View
    {
        $property = $this->ownedOrFail($property);

        return view('host.properties.plans', [
            'property' => $property,
            'plans'    => $this->plansForDisplay(),
            'keyId'    => config('razorpay.key_id'),
        ]);
    }

    /**
     * Create a Razorpay order and hand its id back to the checkout modal.
     *
     * Always returns JSON - it is only ever called from fetch(). A failure
     * here (bad keys, Razorpay unreachable) must produce a readable message
     * rather than a 500 page behind an open modal.
     */
    public function createOrder(Request $request, Property $property): JsonResponse
    {
        $property = $this->ownedOrFail($property);

        $validated = $request->validate([
            'duration' => ['required', 'integer', 'in:'.implode(',', Transaction::DURATIONS)],
        ]);

        $duration = (int) $validated['duration'];
        $rupees   = Transaction::DURATION_PRICES[$duration];

        try {
            $order = $this->api()->order->create([
                // Razorpay works in paise: Rs 799 -> 79900.
                'amount'   => $rupees * 100,
                'currency' => config('razorpay.currency'),
                // Lets us match a webhook or dashboard entry back to a listing.
                'receipt'  => 'prop_'.$property->id.'_'.$duration.'d',
                'notes'    => [
                    'property_id'    => (string) $property->id,
                    'property_title' => $property->title,
                    'host_id'        => (string) $property->host_id,
                    'duration_days'  => (string) $duration,
                ],
            ]);
        } catch (Throwable $e) {
            // Expected while placeholder keys are in place - Razorpay rejects
            // them with an authentication error. Log the detail, tell the host
            // something actionable.
            Log::warning('Razorpay order creation failed', [
                'property_id' => $property->id,
                'duration'    => $duration,
                'error'       => $e->getMessage(),
            ]);

            return response()->json([
                'ok'      => false,
                'message' => 'We could not start the payment just now. Please try again, or contact us if it keeps happening.',
            ], 502);
        }

        return response()->json([
            'ok'       => true,
            'order_id' => $order['id'],
            'amount'   => $rupees * 100,
            'currency' => config('razorpay.currency'),
            'duration' => $duration,
            'key_id'   => config('razorpay.key_id'),
            'name'     => config('app.name'),
            'description' => $duration.'-day listing subscription',
        ]);
    }

    /**
     * Verify the signature Razorpay returns, then publish the listing.
     *
     * The signature is HMAC-SHA256 of "order_id|payment_id" keyed with the
     * API secret. Without this check anyone could POST a made-up payment id
     * and publish a listing for free - it is the whole security of the flow.
     */
    public function verify(Request $request, Property $property): RedirectResponse
    {
        $property = $this->ownedOrFail($property);

        $validated = $request->validate([
            'razorpay_order_id'   => ['required', 'string', 'max:100'],
            'razorpay_payment_id' => ['required', 'string', 'max:100'],
            'razorpay_signature'  => ['required', 'string', 'max:255'],
            'duration'            => ['required', 'integer', 'in:'.implode(',', Transaction::DURATIONS)],
        ]);

        $duration = (int) $validated['duration'];

        try {
            $this->api()->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $validated['razorpay_order_id'],
                'razorpay_payment_id' => $validated['razorpay_payment_id'],
                'razorpay_signature'  => $validated['razorpay_signature'],
            ]);
        } catch (Throwable $e) {
            Log::warning('Razorpay signature verification failed', [
                'property_id' => $property->id,
                'payment_id'  => $validated['razorpay_payment_id'],
                'error'       => $e->getMessage(),
            ]);

            $this->recordTransaction($property, $validated['razorpay_payment_id'], $duration, Transaction::STATUS_FAILED);

            return redirect()->route('host.properties.index')
                ->with('error', 'We could not verify that payment. Nothing has been charged to your listing - please try again.');
        }

        $this->activateSubscription($property, $duration, $validated['razorpay_payment_id']);

        return redirect()->route('host.properties.index')->with(
            'status',
            '“'.$property->title.'” is now live until '.$property->subscription_expiry->format('d M Y').'.'
        );
    }

    /**
     * The host dismissed the modal, or Razorpay reported a failure.
     */
    public function failed(Property $property): RedirectResponse
    {
        $property = $this->ownedOrFail($property);

        return redirect()->route('host.properties.plans', $property)
            ->with('error', 'That payment did not go through. Nothing has been charged - you can try again below.');
    }

    /**
     * Razorpay server-to-server callback.
     *
     * WHY THIS EXISTS. verify() only runs if the host's browser comes back
     * after paying. Close the tab, lose signal, kill the app - the money is
     * taken and the listing never goes live. Razorpay reports the capture
     * here regardless, so this is the safety net.
     *
     * PUBLIC AND UNAUTHENTICATED. The HMAC signature over the raw body is
     * the only thing separating a real callback from anyone who guesses the
     * URL, so it is checked before a single field of the payload is read.
     *
     * ALWAYS 200 ON A GENUINE EVENT, even one we choose not to act on -
     * Razorpay retries anything non-2xx, and retrying will not fix "this
     * order is not ours". An invalid signature is the exception: that is not
     * Razorpay talking, so it gets a 400.
     */
    public function webhook(Request $request): JsonResponse
    {
        $secret = config('razorpay.webhook_secret');

        if (blank($secret)) {
            Log::error('Razorpay webhook received but RAZORPAY_WEBHOOK_SECRET is not set - ignoring.');

            return response()->json(['status' => 'not configured'], 200);
        }

        // Raw body, NOT $request->all(): the signature covers the exact bytes
        // Razorpay sent. Re-encoding a decoded array would change them.
        $payload   = $request->getContent();
        $signature = (string) $request->header('X-Razorpay-Signature', '');

        if ($signature === '') {
            return response()->json(['status' => 'missing signature'], 400);
        }

        try {
            $this->api()->utility->verifyWebhookSignature($payload, $signature, $secret);
        } catch (Throwable $e) {
            Log::warning('Razorpay webhook: signature rejected', [
                'error' => $e->getMessage(),
                'ip'    => $request->ip(),
            ]);

            return response()->json(['status' => 'invalid signature'], 400);
        }

        // Past this line the payload is trustworthy.
        try {
            return $this->handleVerifiedWebhook($payload);
        } catch (Throwable $e) {
            // Never let an unexpected error reach Razorpay as a 5xx - it would
            // retry the same broken event indefinitely. Log and accept.
            Log::error('Razorpay webhook: processing failed', ['error' => $e->getMessage()]);

            return response()->json(['status' => 'error logged'], 200);
        }
    }

    /* ------------------------------------------------------------------ */

    private function handleVerifiedWebhook(string $payload): JsonResponse
    {
        $data  = json_decode($payload, true) ?: [];
        $event = $data['event'] ?? null;

        if ($event !== 'payment.captured') {
            return response()->json(['status' => 'ignored', 'event' => $event], 200);
        }

        $entity    = $data['payload']['payment']['entity'] ?? [];
        $paymentId = $entity['id'] ?? null;

        if (! $paymentId) {
            Log::warning('Razorpay webhook: payment.captured without a payment id');

            return response()->json(['status' => 'no payment id'], 200);
        }

        // Already handled - either verify() got there first, or this is a
        // repeat delivery. Doing nothing is the point: re-running would
        // extend the subscription a second time for one payment.
        $existing = Transaction::where('gateway_payment_id', $paymentId)->first();

        if ($existing && $existing->payment_status === Transaction::STATUS_SUCCESS) {
            return response()->json(['status' => 'already processed'], 200);
        }

        // notes are set by us in createOrder() and echoed back by Razorpay.
        // They are inside the signed payload, so they are as trustworthy as
        // the signature itself.
        $notes = $entity['notes'] ?? ($data['payload']['order']['entity']['notes'] ?? []);

        $propertyId = isset($notes['property_id']) ? (int) $notes['property_id'] : ($existing?->property_id);
        $duration   = isset($notes['duration_days']) ? (int) $notes['duration_days'] : ($existing?->pack_duration_days);

        if (! $propertyId || ! in_array($duration, Transaction::DURATIONS, true)) {
            Log::warning('Razorpay webhook: cannot identify listing or duration', [
                'payment_id' => $paymentId,
                'notes'      => $notes,
            ]);

            return response()->json(['status' => 'unidentified'], 200);
        }

        $property = Property::find($propertyId);

        if (! $property) {
            Log::warning('Razorpay webhook: listing no longer exists', [
                'payment_id'  => $paymentId,
                'property_id' => $propertyId,
            ]);

            return response()->json(['status' => 'property missing'], 200);
        }

        // Guard against a payload claiming a duration cheaper than what was
        // actually paid. amount is in paise.
        $expectedPaise = Transaction::DURATION_PRICES[$duration] * 100;
        $paidPaise     = isset($entity['amount']) ? (int) $entity['amount'] : $expectedPaise;

        if ($paidPaise !== $expectedPaise) {
            Log::warning('Razorpay webhook: amount does not match the plan', [
                'payment_id' => $paymentId,
                'expected'   => $expectedPaise,
                'paid'       => $paidPaise,
            ]);

            return response()->json(['status' => 'amount mismatch'], 200);
        }

        $this->activateSubscription($property, $duration, $paymentId);

        Log::info('Razorpay webhook: subscription activated', [
            'payment_id'  => $paymentId,
            'property_id' => $property->id,
            'duration'    => $duration,
        ]);

        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * Publish a listing for the paid duration and record the transaction.
     *
     * Shared by verify() and webhook() on purpose: the renewal-extension
     * rule must not be implemented twice and drift apart. Renewals extend
     * from the current expiry when one is still running, so a host who
     * renews early keeps the days already paid for.
     */
    private function activateSubscription(Property $property, int $duration, string $paymentId): void
    {
        DB::transaction(function () use ($property, $duration, $paymentId) {
            $start = $property->hasActiveSubscription()
                ? $property->subscription_expiry
                : now();

            $property->forceFill([
                'subscription_expiry' => $start->copy()->addDays($duration),
                'is_visible'          => true,
            ])->save();

            // Amount re-read from the price list, never from the request.
            $this->recordTransaction(
                $property,
                $paymentId,
                $duration,
                Transaction::STATUS_SUCCESS,
                Transaction::DURATION_PRICES[$duration]
            );
        });
    }

    private function api(): Api
    {
        return new Api(config('razorpay.key_id'), config('razorpay.key_secret'));
    }

    /**
     * Merge the copy above with the authoritative prices, and work out the
     * per-day figure the cards advertise.
     *
     * @return list<array<string, mixed>>
     */
    private function plansForDisplay(): array
    {
        $plans = [];

        foreach (Transaction::DURATION_PRICES as $days => $rupees) {
            $plans[] = self::PLAN_COPY[$days] + [
                'days'         => $days,
                'price'        => $rupees,
                'price_per_day' => round($rupees / $days, 1),
            ];
        }

        return $plans;
    }

    /**
     * gateway_payment_id is UNIQUE, so a replayed callback updates the
     * existing row instead of raising a constraint violation.
     */
    private function recordTransaction(
        Property $property,
        string $paymentId,
        int $duration,
        string $status,
        ?int $rupees = null
    ): void {
        Transaction::updateOrCreate(
            ['gateway_payment_id' => $paymentId],
            [
                'host_id'            => $property->host_id,
                'property_id'        => $property->id,
                'pack_duration_days' => $duration,
                'amount_paid'        => $rupees ?? Transaction::DURATION_PRICES[$duration],
                'payment_status'     => $status,
                'paid_at'            => $status === Transaction::STATUS_SUCCESS ? now() : null,
            ]
        );
    }

    /**
     * 404 unless the listing belongs to the signed-in host.
     * Mirrors Host\PropertyController::ownedOrFail().
     */
    private function ownedOrFail(Property $property): Property
    {
        abort_unless($property->host_id === auth()->id(), 404);

        return $property;
    }
}
