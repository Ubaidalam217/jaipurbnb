{{--
  Refund / Cancellation Policy.

  The paragraph inside the first .jb-legal__callout is the CLIENT'S OWN
  WORDING and is reproduced verbatim. Do not paraphrase, re-wrap the
  sentences differently or "improve" it without the client's approval -
  it is the operative clause a payment gateway will be shown during
  merchant review. Everything after it is supporting detail.
--}}
@extends('layouts.legal', [
  'pageTitle' => 'Refund & Cancellation Policy',
  'pageIntro' => 'When a listing subscription fee is refunded, how much is returned, and how long it takes to reach you.',
])

@section('legal_body')

  <h2>1. Listing Fee Refund Policy</h2>

  <div class="jb-legal__callout">
    <p>
      <strong>Listing Fee Refund Policy:</strong> JaipurBnB charges a pre-paid fee to list
      properties. We manually verify all listings within 48 hours of payment. If a property
      fails to meet our verification or quality standards, the listing will be rejected, and
      a 100% refund of the subscription fee will be processed back to the original payment
      source within 5-7 working days.
    </p>
  </div>

  <p>
    The sections below explain how that policy is applied in practice. They supplement, and
    do not override, the clause above.
  </p>

  <h2>2. What you are paying for</h2>
  <p>
    JaipurBnB charges hosts a <strong>pre-paid subscription fee</strong> to publish and
    maintain a property listing for a fixed number of days. The fee buys placement in the
    JaipurBnB directory for that period. It is not a commission, and it is not linked to how
    many enquiries or bookings the listing receives.
  </p>

  <div class="jb-legal__callout">
    <p>
      <strong>Guests never pay JaipurBnB anything.</strong> Browsing listings and contacting
      hosts is free. Any money a guest pays for an actual stay is paid directly to the host,
      off the platform. This policy therefore governs only the host subscription fee. Refunds
      for a stay are a matter between the guest and the host, on whatever terms they agreed.
    </p>
  </div>

  <h2>3. Verification and the 48-hour window</h2>
  <p>
    Every listing is <strong>manually reviewed by a member of our team</strong> — we do not
    auto-approve. Review begins once payment is received and is completed
    <strong>within 48 hours</strong>. Where a submission is received on a Sunday or a public
    holiday, review is completed on the next working day.
  </p>
  <p>The outcome will be one of the following:</p>
  <ul>
    <li><strong>Approved</strong> — your listing goes live immediately and your subscription period begins.</li>
    <li><strong>Rejected</strong> — your listing does not go live and a <strong>100% refund</strong> of the subscription fee is initiated, as set out in section 1.</li>
  </ul>
  <p>
    You will be notified of the outcome by email at the address registered on your host
    account, and the status is also shown on your host dashboard.
  </p>

  <h2>4. When you receive a full refund</h2>
  <p>A <strong>100% refund</strong> of the subscription fee is issued where:</p>
  <ul>
    <li>your listing is <strong>rejected at verification</strong> for failing to meet our verification or quality standards;</li>
    <li>a <strong>duplicate payment</strong> was taken for the same listing and the same period, due to a technical error;</li>
    <li>you were <strong>charged but no listing was created</strong> because of a fault on our side; or</li>
    <li>a payment was <strong>debited but the transaction failed</strong> and did not activate a subscription. Such amounts are usually reversed automatically by the payment gateway or your bank within 5–7 working days.</li>
  </ul>

  <h2>5. When a refund is not available</h2>
  <p>
    Once a listing has been <strong>approved and published</strong>, the subscription fee is
    <strong>non-refundable</strong> for the remainder of that period. In particular, no refund
    is due where:
  </p>
  <ul>
    <li>you choose to remove, hide, pause or delete a live listing before its period ends;</li>
    <li>you are dissatisfied with the number of enquiries, views or bookings received — JaipurBnB sells directory placement, not a guaranteed volume of business;</li>
    <li>your property becomes unavailable, is sold, or you stop hosting;</li>
    <li>the listing or the host account is <strong>suspended or terminated for breach</strong> of our <a href="{{ route('legal.terms') }}">Terms &amp; Conditions</a> or <a href="{{ route('legal.host-terms') }}">Host Listing Terms</a>, including for fraudulent, misleading or unlawful content;</li>
    <li>the subscription simply <strong>expires</strong> at the end of its term; or</li>
    <li>you purchased a longer plan and later wish to move to a shorter one. Plans are not partially refundable or pro-rated.</li>
  </ul>

  <h2>6. Cancellation of a subscription</h2>
  <p>
    Subscriptions are <strong>one-time, fixed-term purchases</strong>. They do not renew
    automatically and no recurring mandate or auto-debit is set up on your card or bank
    account. Nothing further is charged unless you actively purchase a new period.
  </p>
  <p>
    You may stop using the service at any time by simply not renewing. If you wish to take a
    live listing down before its period ends, you may do so from the host dashboard or by
    writing to us — but as set out in section 5, the fee for the current period is not
    refundable.
  </p>

  <h2>7. How refunds are processed</h2>
  <ul>
    <li>Refunds are made <strong>only to the original payment source</strong> used for the transaction — the same card, UPI handle, wallet or bank account. We cannot redirect a refund to a different instrument or to a third party.</li>
    <li>Refunds are processed through <strong>Razorpay</strong>, our payment gateway.</li>
    <li>JaipurBnB initiates the refund promptly after a rejection decision. The amount is credited <strong>within 5-7 working days</strong>.</li>
    <li>The final leg of the credit is controlled by your bank, card issuer or UPI provider and their processing time may extend the total slightly. Any such delay is outside our control.</li>
    <li>Refunds are made in <strong>Indian Rupees (INR)</strong> for the full amount paid. We do not deduct any processing or administrative charge from a rejection refund.</li>
  </ul>

  <h2>8. How to request a refund</h2>
  <p>
    Where a listing is rejected at verification, <strong>you do not need to do anything</strong>
    — the refund is initiated by us automatically.
  </p>
  <p>In any other case covered by section 4, write to us with:</p>
  <ol>
    <li>the email address registered on your host account;</li>
    <li>the Razorpay payment or order identifier from your payment confirmation email;</li>
    <li>the date and amount of the payment; and</li>
    <li>a short description of the issue.</li>
  </ol>
  <p>
    Send this to
    <a href="mailto:hello@jaipurbnb.com" style="text-transform:none;">hello@jaipurbnb.com</a>.
    We acknowledge refund requests within <strong>24 hours</strong> and confirm the outcome
    within <strong>7 working days</strong> of receiving the information above.
  </p>

  <h2>9. Chargebacks</h2>
  <p>
    If you believe a charge is incorrect, please contact us before raising a chargeback with
    your bank or card issuer. We will almost always be able to resolve the matter faster
    directly. Where a chargeback is raised in respect of a validly delivered, live listing,
    we reserve the right to contest it and to suspend the associated account pending the
    outcome.
  </p>

  <h2>10. Disputes</h2>
  <p>
    Any dispute concerning a refund is governed by the dispute resolution and governing law
    provisions of our <a href="{{ route('legal.terms') }}">Terms &amp; Conditions</a> —
    arbitration seated at Jaipur, Rajasthan, under the laws of India. Complaints may be
    raised with our Grievance Officer at
    <a href="mailto:hello@jaipurbnb.com" style="text-transform:none;">hello@jaipurbnb.com</a>.
  </p>

  <h2>11. Changes to this policy</h2>
  <p>
    We may update this policy from time to time. The version in force at the time you make a
    payment is the version that applies to that payment.
  </p>

@endsection
