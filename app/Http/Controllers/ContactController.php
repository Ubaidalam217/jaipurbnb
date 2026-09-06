<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * The /contact enquiry form.
 *
 * This is the ONE form on the site that reaches JaipurBnB itself. Guest to
 * host contact is deliberately off-platform (WhatsApp/Call buttons on each
 * listing), so this endpoint is for platform-level enquiries only: billing,
 * subscriptions, "how do I list", and so on.
 *
 * The submission is emailed rather than stored. There is no enquiries table
 * and no admin inbox screen in scope, so a mail-and-forget keeps it to one
 * moving part.
 */
class ContactController extends Controller
{
    /**
     * Validate an enquiry and email it to the platform inbox.
     *
     * No email field is collected - the client asked for name/phone/message
     * only and replies happen by phone - so the mail carries no Reply-To.
     */
    public function send(Request $request): RedirectResponse
    {
        // Failure here throws ValidationException, which Laravel turns into a
        // redirect back with $errors and old input automatically. That is the
        // "redirect back with errors" half of the flow; nothing to code.
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'phone'   => ['required', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'message.max' => 'Please keep your message under 2,000 characters.',
        ]);

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

            return back()
                ->withInput()
                ->with('contact_error', 'Sorry, we could not send your message just now. Please email hello@jaipurbnb.com or call us directly.')
                ->withFragment('contact-form');
        }

        return back()
            ->with('contact_success', 'Thanks! Your message has been sent. We usually reply within one working day.')
            ->withFragment('contact-form');
    }

    /**
     * The plain-text mail body.
     *
     * Timestamped in Asia/Kolkata rather than the app's UTC default: the
     * client reads these in IST, and an unlabelled UTC time reads as a
     * five-and-a-half-hour-old enquiry.
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
