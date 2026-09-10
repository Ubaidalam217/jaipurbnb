<?php

/*
|--------------------------------------------------------------------------
| JaipurBnB platform contact details
|--------------------------------------------------------------------------
|
| The number shown in the footer, on /contact and as the phone-format hint
| on the host signup form. This is JaipurBnB's OWN support line - it is not
| a host's number. Per-listing WhatsApp/Call buttons always use the host's
| users.phone_number and are unaffected by this value.
|
| Set CONTACT_PHONE in .env. The default below is a deliberate placeholder
| ("+91 00000 00000") so an unconfigured deployment reads as obviously
| unset rather than dialling a real stranger's line.
|
*/

$phone = env('CONTACT_PHONE', '+91 00000 00000');

return [

    // Where the /contact enquiry form delivers, and the address published on
    // the legal pages. Set CONTACT_EMAIL in .env. Read through config() and
    // never env() directly from a controller - env() returns null once
    // config:cache has run on the server.
    'email' => env('CONTACT_EMAIL', 'jaipurbnb@jaipurbnb.com'),

    // Display form, exactly as typed in .env (spaces and all).
    'phone' => $phone,

    // Same number stripped to what a tel: href accepts. Derived here so no
    // Blade template has to repeat the formatting rule.
    'phone_tel' => preg_replace('/[^0-9+]/', '', (string) $phone),

];
