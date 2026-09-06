<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

/**
 * The enquiry form that reaches JaipurBnB itself.
 *
 * Guest to host contact is deliberately off-platform (WhatsApp/Call buttons
 * on each listing), so this endpoint is for platform-level enquiries only:
 * billing, subscriptions, "how do I list", and so on.
 *
 * TWO forms post here:
 *   - the main form on /contact                 (source=page,   #contact-form)
 *   - the "Send Us A Message" footer card       (source=footer, #footer-contact)
 * The footer renders site-wide, so on /contact both are on the page at once.
 * Every response therefore carries a contact_source marker and the matching
 * fragment, and each form renders alerts and old input only when the marker
 * names it. Without that, a footer validation error also lights up the page
 * form and repopulates it with the other form's input.
 *
 * The submission is emailed rather than stored. There is no enquiries table
 * and no admin inbox screen in scope, so a mail-and-forget keeps it to one
 * moving part.
 */
class ContactController extends Controller
{
    /**
     * Which form posted, and the anchor to send the browser back to.
     *
     * Anything other than an explicit 'footer' is treated as the page form,
     * so a stale cached page that posts no source still lands somewhere sane.
     *
     * @var array<string, string>
     */
    private const ANCHORS = [
        'page'   => 'contact-form',
        'footer' => 'footer-contact',
    ];

    /**
     * Validate an enquiry and email it to the platform inbox.
     *
     * No email field is collected - the client asked for name/phone/message
     * only and replies happen by phone - so the mail carries no Reply-To.
     */
    public function send(Request $request): RedirectResponse
    {
        $source = $request->input('source') === 'footer' ? 'footer' : 'page';

        $validator = Validator::make($request->all(), [
            'name'    => ['required', 'string', 'max:100'],
            'phone'   => ['required', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'message.max' => 'Please keep your message under 2,000 characters.',
        ]);

        // Deliberately not $request->validate(): that throws ValidationException
        // immediately, before the source marker and fragment can be attached to
        // the redirect, and the footer form would bounce to the top of whatever
        // page it was submitted from with its error shown on the wrong form.
        if ($validator->fails()) {
            return $this->backTo($source)
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        try {
            Mail::raw($this->body($validated, $request), function ($mail) {
                // config(), not env() - env() returns null once config:cache
                // has run on the server. See config/contact.php.
                $mail->to(config('contact.email'))
                    ->subject('New Contact Form Submission from JaipurBnB');
            });
        } catch (Throwable $e) {
            // A dead SMTP box must not throw a 500 at a guest who did nothing
            // wrong. Log the real reason for us, show a fallback to them - the
            // page still lists the email address and phone number.
            Log::error('Contact form email failed', [
                'error' => $e->getMessage(),
                'name'  => $validated['name'],
                'phone' => $validated['phone'],
            ]);

            return $this->backTo($source)
                ->withInput()
                ->with('contact_error', 'Sorry, we could not send your message just now. Please email hello@jaipurbnb.com or call us directly.');
        }

        return $this->backTo($source)
            ->with('contact_success', 'Thanks! Your message has been sent. We usually reply within one working day.');
    }

    /**
     * Redirect back to the form that was submitted.
     *
     * The contact_source marker is what each form checks before rendering a
     * flash message or repopulating old input, and the fragment scrolls the
     * browser to that form so the message is actually in view - the footer
     * card is at the bottom of a long page.
     */
    private function backTo(string $source): RedirectResponse
    {
        return back()
            ->with('contact_source', $source)
            ->withFragment(self::ANCHORS[$source]);
    }

    /**
     * The plain-text mail body.
     *
     * Timestamped in Asia/Kolkata rather than the app's UTC default: the
     * client reads these in IST, and an unlabelled UTC time reads as a
     * five-and-a-half-hour-old enquiry.
     *
     * "Page" is the URL the guest was on when they submitted. Worth carrying
     * now that the footer card posts here from everywhere: an enquiry sent
     * from a property page is a different conversation from one sent off the
     * homepage, and the client cannot tell them apart otherwise.
     *
     * @param  array{name: string, phone: string, message: string}  $data
     */
    private function body(array $data, Request $request): string
    {
        return implode("\n", [
            'New contact form submission from jaipurbnb.com',
            '',
            'Name:    '.$data['name'],
            'Phone:   '.$data['phone'],
            'Sent at: '.now()->timezone('Asia/Kolkata')->format('d M Y, g:i A').' IST',
            'Page:    '.($request->headers->get('referer') ?: 'unknown'),
            'IP:      '.$request->ip(),
            '',
            'Message:',
            $data['message'],
            '',
            '--',
            'Sent automatically by the JaipurBnB contact form.',
        ]);
    }
}
