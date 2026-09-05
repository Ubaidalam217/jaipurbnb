{{--
  Host / Property Listing Terms - the host-facing counterpart to the general
  Terms & Conditions. Operational details here mirror the real app:
  30/90/365-day plans (Transaction::DURATION_PRICES), up to 15 photos per
  listing, manual admin approval before going live, the daily expiry cron
  that flips is_visible to false while preserving data, and one-way iCal
  pull. Keep in sync if any of those change.
--}}
@extends('layouts.legal', [
  'pageTitle' => 'Host & Property Listing Terms',
  'pageIntro' => 'The additional terms that apply when you list a property on JaipurBnB, your responsibilities, how verification works, and how subscriptions run.',
])

@section('legal_body')

  <h2>1. Scope of these terms</h2>
  <p>
    These Host &amp; Property Listing Terms (“Host Terms”) apply to every person or entity
    that creates a host account or lists a property on <strong>JaipurBnB</strong>. They are
    <strong>in addition to</strong>, and form part of, our
    <a href="{{ route('legal.terms') }}">Terms &amp; Conditions</a>. Where these Host Terms
    conflict with the general Terms on a host-specific matter, these Host Terms prevail.
  </p>
  <p>
    Please also read our <a href="{{ route('legal.refund') }}">Refund &amp; Cancellation
    Policy</a> and <a href="{{ route('legal.privacy') }}">Privacy Policy</a>.
  </p>

  <h2>2. The relationship between us</h2>
  <div class="jb-legal__callout">
    <p>
      You list your property as an <strong>independent operator</strong>. Nothing in these
      Host Terms creates a partnership, joint venture, agency, franchise or
      employer-employee relationship between you and JaipurBnB. We do not manage your
      property, set your tariffs, take bookings on your behalf, hold guest money, or act as
      your agent in any dealing with a guest.
    </p>
  </div>
  <p>
    JaipurBnB provides <strong>directory placement only</strong>. Guests contact you
    directly over WhatsApp or telephone, and every reservation, tariff, deposit, house rule
    and cancellation arrangement is agreed directly between you and the guest, off the
    platform.
  </p>

  <h2>3. Host eligibility and legal compliance</h2>
  <p>By listing a property you represent and warrant, on a continuing basis, that:</p>
  <ul>
    <li>you are at least 18 years old and competent to contract;</li>
    <li>you are the <strong>owner of the property</strong>, or you hold a valid written authority from the owner permitting you to offer it as short-stay accommodation and to advertise it;</li>
    <li>letting the property for short stays does not breach any <strong>lease, mortgage, society by-law, resident welfare association rule, sub-lease restriction or municipal regulation</strong> applicable to it;</li>
    <li>you hold every <strong>registration, licence, permission or no-objection certificate</strong> required to operate the property, including any registration required by the Rajasthan tourism authorities or the local municipal body;</li>
    <li>you comply with all applicable <strong>fire safety, building safety and public health</strong> requirements;</li>
    <li>you will comply with <strong>guest identification and record-keeping obligations</strong> applicable to accommodation providers, including verification of guest identity documents and, where applicable, Form C reporting for foreign nationals under the Foreigners Act, 1946; and</li>
    <li>you are solely responsible for your own <strong>tax obligations</strong>, including income tax and GST registration and filings where applicable to your hosting income.</li>
  </ul>
  <p>
    <strong>JaipurBnB does not verify your title, permissions, licences or tax status.</strong>
    Compliance is entirely your responsibility, and you indemnify us against any claim
    arising from your failure to comply.
  </p>

  <h2>4. Accuracy of your listing</h2>
  <p>You must ensure that your listing is truthful, current and complete. Specifically:</p>
  <ul>
    <li><strong>Photographs</strong> must be of the actual property being listed, taken within a reasonable recent period, and must not be stock images, renders, images of a different property, or images edited so as to misrepresent the space.</li>
    <li><strong>Descriptions and amenities</strong> must accurately reflect what a guest will actually receive. Do not list amenities that are unavailable, out of order or chargeable extra without saying so.</li>
    <li><strong>Location and neighbourhood</strong> must be stated accurately. Do not select a more desirable neighbourhood than the one the property is actually in.</li>
    <li><strong>Tariffs</strong> shown must be the genuine rates you intend to honour. Any mandatory additional charge (cleaning fee, deposit, extra-guest charge) must be disclosed in the listing.</li>
    <li><strong>Contact number</strong> must be a working number that you control and that can receive WhatsApp messages and calls. It will be displayed publicly to guests.</li>
    <li><strong>Availability</strong> shown on your calendar must be kept up to date.</li>
  </ul>
  <p>
    You must update your listing promptly whenever any of the above changes. Persistent
    inaccuracy is a breach of these Host Terms.
  </p>

  <h2>5. Photographs and content licence</h2>
  <p>
    You may upload <strong>up to fifteen (15) photographs per listing</strong>. You confirm
    that you own the copyright in each image or have the photographer's permission to use
    it, and that no image contains an identifiable person who has not consented to its
    publication.
  </p>
  <p>
    You grant JaipurBnB a non-exclusive, royalty-free, worldwide licence to host, store,
    reproduce, resize, display and distribute your listing content for the purpose of
    operating, promoting and marketing the platform, as set out in section 7.2 of the
    <a href="{{ route('legal.terms') }}">Terms &amp; Conditions</a>.
  </p>

  <h2>6. Verification and approval</h2>
  <p>
    Every listing is <strong>manually reviewed by our team before it goes live</strong>. A
    listing moves through three states:
  </p>
  <ul>
    <li><strong>Pending approval</strong>, submitted and paid for, awaiting our review. Not visible to guests.</li>
    <li><strong>Approved and live</strong>, published in the directory and visible to guests for the duration of your subscription.</li>
    <li><strong>Rejected</strong>, not published, and a full refund is initiated under the <a href="{{ route('legal.refund') }}">Refund &amp; Cancellation Policy</a>.</li>
  </ul>
  <p>Review is completed <strong>within 48 hours</strong> of payment. We may reject a listing where, in our reasonable judgement:</p>
  <ul>
    <li>the photographs are of insufficient quality, are duplicated from elsewhere, or do not depict the property;</li>
    <li>the description is incomplete, misleading, or does not match the photographs;</li>
    <li>the property is outside Jaipur, or is not a genuine short-stay property;</li>
    <li>the contact number is invalid or unreachable;</li>
    <li>the listing contains prohibited content (section 8); or</li>
    <li>we have a reasonable basis to suspect the listing is fraudulent or that you lack the right to list the property.</li>
  </ul>
  <p>
    We will tell you the reason for rejection by email. You are welcome to correct the
    issues and submit again. <strong>Approval is not an endorsement</strong> of your property
    and does not mean we have verified your licences, safety, title or any factual claim in
    your listing.
  </p>

  <h2>7. Subscription terms</h2>
  <p>
    Listings are published on a <strong>pre-paid, fixed-term subscription</strong>. Plans of
    <strong>30, 90 and 365 days</strong> are offered at the prices displayed on the platform
    at the time of purchase, in Indian Rupees.
  </p>
  <ul>
    <li>Your subscription period begins when your listing is <strong>approved and published</strong>, not when you pay.</li>
    <li>Subscriptions are <strong>one-time purchases and do not auto-renew</strong>. No recurring mandate is created on your card or bank account.</li>
    <li>We send an expiry reminder to your registered email address before the period ends.</li>
    <li>When a subscription expires, the listing is automatically <strong>hidden from public view</strong>. Your listing data, photographs and lead history are <strong>preserved, not deleted</strong>, so renewing restores the listing as it was.</li>
    <li>Payments are processed by <strong>Razorpay</strong>. JaipurBnB never sees or stores your card, UPI or bank credentials.</li>
    <li>A subscription covers <strong>one property listing</strong>. Each additional property requires its own subscription.</li>
    <li>Subscriptions are not transferable between properties or between host accounts.</li>
  </ul>
  <div class="jb-legal__callout">
    <p>
      <strong>The subscription fee buys directory placement for a fixed period. It does not
      guarantee any number of views, enquiries, bookings or any level of revenue.</strong>
      Dissatisfaction with the volume of business received is not a ground for a refund. See
      the <a href="{{ route('legal.refund') }}">Refund &amp; Cancellation Policy</a>.
    </p>
  </div>

  <h2>8. Prohibited content and conduct</h2>
  <p>You must not, in a listing or in dealings with guests through the platform:</p>
  <ul>
    <li>list a property that does not exist, that you have no right to offer, or that is already unavailable;</li>
    <li>use photographs, descriptions or copy taken from another listing, website or host;</li>
    <li>publish content that is obscene, defamatory, harassing, or objectionable on grounds of religion, caste, gender, race or ethnicity;</li>
    <li>discriminate against guests on any ground prohibited by law;</li>
    <li>include contact details, external booking links or promotional material for services unrelated to the listed property;</li>
    <li>advertise a property for any unlawful purpose, or permit unlawful activity on the premises;</li>
    <li>quote one tariff on the platform and demand a materially higher one when the guest calls (“bait pricing”);</li>
    <li>solicit payment from guests through the JaipurBnB brand, or represent to a guest that JaipurBnB guarantees, insures or underwrites their stay;</li>
    <li>create multiple accounts or duplicate listings for the same property to occupy more space in search results; or</li>
    <li>attempt to manipulate listing analytics, rankings or engagement counts by any artificial means.</li>
  </ul>

  <h2>9. Calendar synchronisation</h2>
  <p>
    You may optionally connect an external availability calendar by supplying an iCal feed
    URL from another platform. If you do:
  </p>
  <ul>
    <li>Synchronisation is <strong>one-way only</strong>. We read dates from your feed and block them on JaipurBnB. We never write, push or send anything back to that platform.</li>
    <li>The feed is fetched <strong>periodically</strong>, so there can be a short lag between a change on the source platform and its appearance here. You remain responsible for confirming actual availability with each guest.</li>
    <li>You confirm you are entitled to share that feed URL with us, and that doing so does not breach the other platform's terms.</li>
    <li>We are not liable for any double-booking, overbooking or lost booking arising from a delay, failure or inaccuracy in a third-party feed.</li>
  </ul>

  <h2>10. Your responsibilities to guests</h2>
  <p>
    Because bookings happen directly between you and the guest, you are
    <strong>solely responsible</strong> for the stay. This includes:
  </p>
  <ul>
    <li>responding to enquiries honestly and in reasonable time;</li>
    <li>honouring the tariff and terms you agreed with the guest;</li>
    <li>providing the property in the condition described, clean, safe and habitable;</li>
    <li>handling check-in, check-out, deposits, cancellations and refunds on the terms you agreed with the guest;</li>
    <li>maintaining adequate <strong>property and public liability insurance</strong>, JaipurBnB provides no insurance, guarantee or host protection cover of any kind; and</li>
    <li>resolving any dispute with the guest directly.</li>
  </ul>
  <p>
    You indemnify JaipurBnB against any claim brought by a guest or any third party arising
    out of your property or your conduct as a host, as set out in section 10 of the
    <a href="{{ route('legal.terms') }}">Terms &amp; Conditions</a>.
  </p>

  <h2>11. Analytics provided to you</h2>
  <p>
    Your dashboard shows counts of listing profile views and of taps on the WhatsApp and
    Call buttons. These figures are provided for your guidance only, on a best-efforts
    basis. They may be affected by caching, bot traffic, ad blockers or technical faults,
    and we do not warrant their accuracy. They are not a measure of confirmed bookings.
  </p>

  <h2>12. Suspension, removal and termination</h2>
  <p>
    We may <strong>remove a listing, suspend it, or terminate your host account</strong> with
    immediate effect where we reasonably believe that:
  </p>
  <ul>
    <li>you have breached these Host Terms, the Terms &amp; Conditions, or applicable law;</li>
    <li>your listing is fraudulent, materially misleading, or duplicated;</li>
    <li>you lack the legal right to list the property;</li>
    <li>you have engaged in prohibited conduct under section 8; or</li>
    <li>we receive credible complaints from guests about safety, misrepresentation or serious misconduct.</li>
  </ul>
  <p>
    Where practicable we will notify you and, if the issue is capable of being fixed, give
    you an opportunity to fix it. <strong>No refund is due where a listing is removed or an
    account terminated for breach.</strong>
  </p>
  <p>
    You may close your host account at any time by writing to
    <a href="mailto:hello@jaipurbnb.com" style="text-transform:none;">hello@jaipurbnb.com</a>.
    Closing an account does not entitle you to a refund of any live subscription.
  </p>

  <h2>13. Changes to these Host Terms</h2>
  <p>
    We may amend these Host Terms to reflect changes in the service or in applicable law.
    Material changes will be notified by email to the address registered on your host
    account, and the updated version will be posted here. Changes do not affect the price or
    duration of a subscription you have already purchased.
  </p>

  <h2>14. Governing law</h2>
  <p>
    These Host Terms are governed by the <strong>laws of India</strong> and are subject to the
    dispute resolution and jurisdiction provisions in sections 13 and 14 of the
    <a href="{{ route('legal.terms') }}">Terms &amp; Conditions</a>, arbitration seated at
    <strong>Jaipur, Rajasthan</strong>, with the courts at Jaipur having exclusive
    jurisdiction.
  </p>

@endsection
