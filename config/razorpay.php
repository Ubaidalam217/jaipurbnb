<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Razorpay API credentials
    |--------------------------------------------------------------------------
    |
    | Test keys start with "rzp_test_", live keys with "rzp_live_". Both come
    | from the Razorpay dashboard: Settings -> API Keys.
    |
    | The secret is used server-side only - to create orders and to verify the
    | HMAC signature that comes back from checkout. It must never reach a
    | Blade template or any JavaScript. Only key_id is safe to expose to the
    | browser.
    |
    */

    'key_id'     => env('RAZORPAY_KEY_ID'),
    'key_secret' => env('RAZORPAY_KEY_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Webhook secret
    |--------------------------------------------------------------------------
    |
    | A SEPARATE secret from key_secret, set when you create the webhook in the
    | Razorpay dashboard (Settings -> Webhooks). It signs the request body so
    | we can tell a genuine Razorpay callback from anyone who found the URL -
    | the webhook route is public and unauthenticated, so this signature is
    | the only thing standing between a stranger and a free listing.
    |
    | Endpoint to register:  https://<your-domain>/webhooks/razorpay
    | Event to subscribe to: payment.captured
    |
    */

    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | Razorpay works in the smallest currency unit, so INR amounts are sent as
    | paise (Rs 799 -> 79900). The conversion lives in PaymentController, not
    | here, so there is one place to look for it.
    |
    */

    'currency' => 'INR',

];
