<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

/**
 * The /contact enquiry form.
 *
 * ContactController mails the submission and stores nothing, so these tests
 * assert on the outgoing mail rather than on any table. No RefreshDatabase:
 * the endpoint never touches the database.
 *
 * NOTE: these deliberately do NOT use Mail::fake(). MailFake::raw() is an
 * empty stub - it records nothing - so every assertion against a Mail::raw()
 * send silently passes with zero mailables. phpunit.xml already pins
 * MAIL_MAILER=array, so we read the sent messages off the array transport
 * instead, which is the only way to see a raw send.
 */
class ContactFormTest extends TestCase
{
    /** @var array<string, string> */
    private const VALID = [
        'name'    => 'Ananya Sharma',
        'phone'   => '+91 98765 43210',
        'message' => 'Hi, I want to list my haveli in Amer. What does it cost?',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        // The array transport is a singleton for the process; messages from a
        // previous test would otherwise leak into this one's counts. flush()
        // is on the transport, not on the returned Collection.
        Mail::mailer()->getSymfonyTransport()->flush();
    }

    /**
     * @return \Illuminate\Support\Collection<int, \Symfony\Component\Mailer\SentMessage>
     */
    private function sentMessages()
    {
        return Mail::mailer()->getSymfonyTransport()->messages();
    }

    public function test_the_contact_page_renders_the_form(): void
    {
        $this->get('/contact')
            ->assertStatus(200)
            ->assertSee(route('contact.send'))
            ->assertSee('name="name"', false)
            ->assertSee('name="phone"', false)
            ->assertSee('name="message"', false)
            // Laravel's @csrf directive renders a _token hidden input.
            ->assertSee('name="_token"', false);
    }

    public function test_a_valid_submission_is_emailed_to_the_platform_inbox(): void
    {
        config(['contact.email' => 'inbox@jaipurbnb.test']);

        $this->post('/contact', self::VALID)
            ->assertRedirect()
            ->assertSessionHas('contact_success')
            ->assertSessionHasNoErrors();

        $this->assertCount(1, $this->sentMessages());

        $email = $this->sentMessages()->first()->getOriginalMessage();
        $body  = $email->getTextBody();

        $this->assertSame('inbox@jaipurbnb.test', $email->getTo()[0]->getAddress());
        $this->assertSame('New Contact Form Submission from JaipurBnB', $email->getSubject());
        $this->assertStringContainsString(self::VALID['name'], $body);
        $this->assertStringContainsString(self::VALID['phone'], $body);
        $this->assertStringContainsString(self::VALID['message'], $body);
        // The body carries a timestamp, labelled IST rather than the app's UTC.
        $this->assertStringContainsString('IST', $body);
    }

    /**
     * @return array<string, array{array<string, string>, string}>
     */
    public static function invalidPayloads(): array
    {
        return [
            'name missing'     => [['name' => ''], 'name'],
            'name too long'    => [['name' => str_repeat('a', 101)], 'name'],
            'phone missing'    => [['phone' => ''], 'phone'],
            'phone too long'   => [['phone' => str_repeat('9', 21)], 'phone'],
            'message missing'  => [['message' => ''], 'message'],
            'message too long' => [['message' => str_repeat('a', 2001)], 'message'],
        ];
    }

    /**
     * @dataProvider invalidPayloads
     *
     * @param  array<string, string>  $override
     */
    public function test_invalid_input_redirects_back_with_errors_and_sends_nothing(array $override, string $field): void
    {
        $this->from('/contact')
            ->post('/contact', array_merge(self::VALID, $override))
            ->assertRedirect('/contact')
            ->assertSessionHasErrors($field);

        $this->assertCount(0, $this->sentMessages());
    }

    public function test_the_boundary_lengths_are_accepted(): void
    {
        $this->post('/contact', [
            'name'    => str_repeat('a', 100),
            'phone'   => str_repeat('9', 20),
            'message' => str_repeat('a', 2000),
        ])->assertSessionHasNoErrors();

        $this->assertCount(1, $this->sentMessages());
    }

    /**
     * A guest who filled the form in correctly must not see a 500 because our
     * SMTP box is down - they get the fallback notice and keep their input.
     */
    public function test_a_mail_failure_degrades_to_a_flash_message(): void
    {
        Mail::shouldReceive('raw')->once()->andThrow(new RuntimeException('smtp down'));

        $this->from('/contact')
            ->post('/contact', self::VALID)
            ->assertRedirect('/contact#contact-form')
            ->assertSessionHas('contact_error')
            ->assertSessionHasNoErrors();
    }

    /**
     * The endpoint is public and sends mail, so it is rate limited. Guards
     * against the throttle middleware being dropped from the route.
     */
    public function test_the_endpoint_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/contact', self::VALID)->assertRedirect();
        }

        $this->post('/contact', self::VALID)->assertStatus(429);
        $this->assertCount(5, $this->sentMessages());
    }
}
