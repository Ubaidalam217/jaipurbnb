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
    /**
     * NOTE: these tests hit the network. The email rule is email:rfc,dns, so
     * the domain is resolved for real on every submission.
     *
     * The address must be at a domain that actually ACCEPTS mail. example.com
     * is not usable despite being the obvious choice: it publishes a null MX
     * record ("."), which is the standard way a domain declares it receives no
     * mail, and the validator correctly rejects it. gmail.com is used instead
     * because its MX records are about as stable as DNS gets.
     *
     * @var array<string, string>
     */
    private const VALID = [
        'name'    => 'Ananya Sharma',
        'phone'   => '+91 98765 43210',
        'email'   => 'ananya.sharma@gmail.com',
        'message' => 'Hi, I want to list my haveli in Amer. What does it cost?',
        'consent' => '1',
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
            ->assertSee('value="page"', false)
            // Laravel's @csrf directive renders a _token hidden input.
            ->assertSee('name="_token"', false);
    }

    /**
     * The footer card posts to the same endpoint from every page that renders
     * the footer partial. /terms is used here rather than the homepage only
     * because the homepage queries properties and this class has no database.
     */
    public function test_the_footer_form_renders_site_wide(): void
    {
        $this->get('/terms')
            ->assertStatus(200)
            ->assertSee(route('contact.send'))
            ->assertSee('id="footer-contact"', false)
            ->assertSee('name="source" value="footer"', false)
            ->assertSee('id="footer-contact-name"', false)
            ->assertSee('id="footer-contact-phone"', false)
            ->assertSee('id="footer-contact-message"', false)
            ->assertSee('name="_token"', false)
            // The template shipped type="number", which mangles +91 prefixes.
            ->assertDontSee('placeholder="Mobile Number*" type="number"', false);
    }

    public function test_a_footer_submission_is_emailed_and_returns_to_the_footer_anchor(): void
    {
        $this->from('/terms')
            ->post('/contact', self::VALID + ['source' => 'footer'])
            ->assertRedirect('/terms#footer-contact')
            ->assertSessionHas('contact_success')
            ->assertSessionHas('contact_source', 'footer');

        $this->assertCount(1, $this->sentMessages());
    }

    public function test_the_mail_records_which_page_the_enquiry_came_from(): void
    {
        $this->from('https://jaipurbnb.com/app/property/42')
            ->post('/contact', self::VALID + ['source' => 'footer']);

        $this->assertStringContainsString(
            'https://jaipurbnb.com/app/property/42',
            $this->sentMessages()->first()->getOriginalMessage()->getTextBody()
        );
    }

    /**
     * Both forms are on /contact at once and share one error bag and one set
     * of old input, so a footer submission must not light up the page form -
     * and vice versa.
     *
     * The assertion counts data-contact-alert hooks rather than CSS classes:
     * the page's <style> block literally contains the string
     * ".jb-auth__alert--ok", so matching on class names gives false hits.
     *
     * @return array<string, array{string, string, string}>
     */
    public static function formSources(): array
    {
        //          source      renders alerts   stays silent
        return [
            'footer' => ['footer', 'footer', 'page'],
            'page'   => ['page', 'page', 'footer'],
        ];
    }

    /**
     * @dataProvider formSources
     */
    public function test_an_error_shows_only_on_the_form_that_was_submitted(string $source, string $shows, string $silent): void
    {
        $this->from('/contact')
            ->post('/contact', ['source' => $source, 'name' => '', 'phone' => '9', 'message' => 'x'])
            ->assertRedirect('/contact#'.($source === 'footer' ? 'footer-contact' : 'contact-form'))
            ->assertSessionHasErrors('name');

        $html = $this->get('/contact')->assertStatus(200)->getContent();

        $this->assertSame(1, substr_count($html, 'data-contact-alert="'.$shows.'"'));
        $this->assertSame(0, substr_count($html, 'data-contact-alert="'.$silent.'"'));

        // The page form's per-field error span only ever belongs to the page form.
        $source === 'page'
            ? $this->assertStringContainsString('id="contact-name-error"', $html)
            : $this->assertStringNotContainsString('id="contact-name-error"', $html);
    }

    /**
     * @dataProvider formSources
     */
    public function test_a_success_message_shows_only_on_the_form_that_was_submitted(string $source, string $shows, string $silent): void
    {
        $this->from('/contact')->post('/contact', self::VALID + ['source' => $source]);

        $html = $this->get('/contact')->assertStatus(200)->getContent();

        $this->assertSame(1, substr_count($html, 'data-contact-alert="'.$shows.'"'));
        $this->assertSame(0, substr_count($html, 'data-contact-alert="'.$silent.'"'));
        $this->assertStringContainsString('Thanks! Your message has been sent.', $html);
    }

    /**
     * Old input must not cross over either - a footer submission that fails
     * validation must leave the page form's inputs empty.
     */
    public function test_old_input_does_not_cross_between_the_two_forms(): void
    {
        $this->from('/contact')
            ->post('/contact', ['source' => 'footer', 'name' => 'Footer Person', 'phone' => '', 'message' => 'x']);

        $html = $this->get('/contact')->assertStatus(200)->getContent();

        // Once, in the footer input - not also in the page form's input.
        $this->assertSame(1, substr_count($html, 'Footer Person'));
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
        $this->assertStringContainsString(self::VALID['email'], $body);
        $this->assertStringContainsString(self::VALID['message'], $body);
        // The body carries a timestamp, labelled IST rather than the app's UTC.
        $this->assertStringContainsString('IST', $body);
        // The only durable record that consent was given - there is no
        // enquiries table.
        $this->assertStringContainsString('Consent:', $body);

        // Reply-To, not From: From has to stay the authenticated SMTP account
        // or the mail fails SPF for the guest's domain. Reply-To is what makes
        // "Reply" in the client's inbox reach the guest.
        $this->assertSame(self::VALID['email'], $email->getReplyTo()[0]->getAddress());
        $this->assertNotSame(self::VALID['email'], $email->getFrom()[0]->getAddress());
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
            'email missing'    => [['email' => ''], 'email'],
            'email malformed'  => [['email' => 'not-an-email'], 'email'],
            // Syntactically valid but the domain does not resolve - this is
            // what the dns half of email:rfc,dns is there to catch, and the
            // reason the rule is not just 'email'.
            'email domain does not resolve' => [['email' => 'guest@thisdomaindoesnotexist.invalid'], 'email'],
            'email too long'   => [['email' => str_repeat('a', 250).'@gmail.com'], 'email'],
            // An unticked box is omitted from the payload entirely by the
            // browser, so '' is the closest a test can get to reproducing it;
            // both must fail.
            'consent unticked' => [['consent' => ''], 'consent'],
            'consent refused'  => [['consent' => '0'], 'consent'],
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
            // No source posted, so it is treated as the page form.
            ->assertRedirect('/contact#contact-form')
            ->assertSessionHasErrors($field);

        $this->assertCount(0, $this->sentMessages());
    }

    public function test_the_boundary_lengths_are_accepted(): void
    {
        $this->post('/contact', [
            'name'    => str_repeat('a', 100),
            'phone'   => str_repeat('9', 20),
            // 255 chars exactly: 245 + '@gmail.com' (10).
            'email'   => str_repeat('a', 245).'@gmail.com',
            'message' => str_repeat('a', 2000),
            'consent' => '1',
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
