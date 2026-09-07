{{--
  Terms & Conditions. Governing law is India / Jaipur, Rajasthan.

  The registered business details in section 1 (Udyam number, principal place
  of business, date of incorporation) and the Grievance Officer named in
  section 12 were supplied by the client and are the real, operative details.
  Do not edit them without the client's confirmation. The support email is
  read from config('contact.email') / CONTACT_EMAIL so it stays in step with
  the /contact form inbox. Have a practising advocate review these four
  documents before relying on them.
--}}
@extends('layouts.legal', [
  'pageTitle' => 'Terms & Conditions',
  'pageIntro' => 'The rules that govern your use of the JaipurBnB website and services. Please read them carefully before using the platform.',
])

@section('legal_body')

  <div class="jb-legal__toc">
    <h2>On this page</h2>
    <ol>
      <li>Who we are</li>
      <li>Acceptance of these terms</li>
      <li>What JaipurBnB is, and what it is not</li>
      <li>Eligibility</li>
      <li>Your account</li>
      <li>Acceptable use of the platform</li>
      <li>Listings, content and intellectual property</li>
      <li>Fees and payments</li>
      <li>Disclaimers and limitation of liability</li>
      <li>Indemnity</li>
      <li>Suspension and termination</li>
      <li>Grievance redressal</li>
      <li>Dispute resolution</li>
      <li>Governing law and jurisdiction</li>
      <li>Changes to these terms</li>
    </ol>
  </div>

  <h2>1. Who we are</h2>
  <p>
    <strong>JaipurBNB</strong> (“JaipurBnB”, “we”, “us” or “our”) operates the website at
    <strong>jaipurbnb.com</strong>, a paid property listing directory for short-stay and
    holiday accommodation located in Jaipur, Rajasthan, India.
  </p>
  <div class="jb-legal__callout">
    <p>
      <strong>Business name:</strong> JaipurBNB<br>
      <strong>Udyam Registration Number:</strong> UDYAM-RJ-17-0665133<br>
      <strong>Date of incorporation:</strong> 23 July 2026<br>
      <strong>Principal place of business:</strong> 401, Kings Avenue, Kings Road, Nirman Nagar AB, Jaipur, Rajasthan 302019, India<br>
      <strong>Email:</strong> <a href="mailto:{{ config('contact.email') }}" style="text-transform:none;">{{ config('contact.email') }}</a><br>
      <strong>Phone:</strong> <a href="tel:{{ config('contact.phone_tel') }}">{{ config('contact.phone') }}</a>
    </p>
  </div>
  <p>
    For the purposes of the Information Technology Act, 2000 and the rules made under it,
    JaipurBnB is an <strong>intermediary</strong>. We publish listing information supplied
    by third-party hosts. We do not own, operate, manage, inspect on an ongoing basis, or
    control any of the properties listed on the platform.
  </p>

  <h2>2. Acceptance of these terms</h2>
  <p>
    These Terms &amp; Conditions (“Terms”) form a legally binding agreement between you and
    JaipurBnB under the Indian Contract Act, 1872. By accessing the website, creating an
    account, listing a property, or contacting a host through the platform, you confirm
    that you have read, understood and agreed to these Terms, our
    <a href="{{ route('legal.privacy') }}">Privacy Policy</a>, our
    <a href="{{ route('legal.refund') }}">Refund &amp; Cancellation Policy</a> and, if you
    list a property, our <a href="{{ route('legal.host-terms') }}">Host Listing Terms</a>.
  </p>
  <p>If you do not agree with any part of these Terms, please do not use the platform.</p>

  <h2>3. What JaipurBnB is, and what it is not</h2>
  <p>
    JaipurBnB is a <strong>discovery and listing directory</strong>. Hosts pay a
    subscription fee to display their property. Guests browse the directory free of charge
    and contact hosts directly over WhatsApp or telephone.
  </p>

  <div class="jb-legal__callout">
    <p>
      <strong>No bookings and no guest payments take place on JaipurBnB.</strong> We are not
      a travel agent, tour operator, booking engine, escrow service or payment intermediary
      for stays. Any reservation, tariff, security deposit, cancellation arrangement,
      house rule or refund between a guest and a host is agreed <strong>directly and
      exclusively between those two parties</strong>, entirely off the platform. JaipurBnB
      is not a party to that arrangement and holds no money on behalf of either party.
    </p>
  </div>

  <p>
    The only payment JaipurBnB collects is the <strong>listing subscription fee paid by
    hosts</strong>, described in section 8 and in our
    <a href="{{ route('legal.refund') }}">Refund &amp; Cancellation Policy</a>.
  </p>

  <h2>4. Eligibility</h2>
  <p>You may use the platform only if you:</p>
  <ul>
    <li>are at least 18 years of age and competent to contract under the Indian Contract Act, 1872;</li>
    <li>are not barred from receiving services under any applicable Indian law; and</li>
    <li>provide accurate, current and complete information when asked for it.</li>
  </ul>
  <p>
    If you use the platform on behalf of a firm, company or other entity, you confirm that
    you are authorised to bind that entity to these Terms.
  </p>

  <h2>5. Your account</h2>
  <p>
    Guests do not need an account to browse listings or contact hosts. Hosts must register
    an account to create and manage listings.
  </p>
  <ul>
    <li>You are responsible for keeping your password confidential and for all activity that takes place under your account.</li>
    <li>You must notify us promptly at <a href="mailto:{{ config('contact.email') }}" style="text-transform:none;">{{ config('contact.email') }}</a> if you suspect unauthorised access to your account.</li>
    <li>You may not sell, transfer or share your account with any other person.</li>
    <li>You may not create an account using another person's identity or contact details.</li>
  </ul>

  <h2>6. Acceptable use of the platform</h2>
  <p>You agree that you will <strong>not</strong>:</p>
  <ul>
    <li>publish, transmit or store any information that is defamatory, obscene, invasive of another's privacy, insulting or harassing on the basis of gender, racially or ethnically objectionable, relating to or encouraging money laundering or gambling, or otherwise unlawful under Indian law;</li>
    <li>infringe any patent, trademark, copyright or other proprietary right;</li>
    <li>impersonate any person or entity, or misrepresent your affiliation with any person or entity;</li>
    <li>list, advertise or promote any property you are not lawfully entitled to offer for short-stay accommodation;</li>
    <li>post false, misleading or deceptive information about a property, its location, its amenities or its availability;</li>
    <li>use the platform to send spam, bulk unsolicited communications, or to harvest contact details of hosts or guests for any purpose other than a genuine accommodation enquiry;</li>
    <li>use any robot, spider, scraper or other automated means to access, copy or index the platform or its listings without our prior written permission;</li>
    <li>attempt to gain unauthorised access to the platform, its servers, or any data stored on them, or introduce any virus, malware or other harmful code;</li>
    <li>interfere with, disrupt or place an unreasonable load on the platform's infrastructure;</li>
    <li>circumvent, disable or otherwise interfere with any security or access-control feature of the platform; or</li>
    <li>use the platform for any purpose that is unlawful or prohibited by these Terms.</li>
  </ul>
  <p>
    We may remove any content that, in our reasonable judgement, violates these Terms or
    applicable law, and may report unlawful activity to the appropriate authorities.
  </p>

  <h2>7. Listings, content and intellectual property</h2>

  <h3>7.1 Our content</h3>
  <p>
    The JaipurBnB name, logo, website design, text, graphics, layout and software are owned
    by or licensed to JaipurBnB and are protected under the Copyright Act, 1957 and the
    Trade Marks Act, 1999. You may not copy, reproduce, republish, distribute or create
    derivative works from them without our prior written consent.
  </p>

  <h3>7.2 Your content</h3>
  <p>
    You retain ownership of the photographs, descriptions and other material you upload
    (“Your Content”). By uploading Your Content you grant JaipurBnB a non-exclusive,
    royalty-free, worldwide licence to host, store, reproduce, display, resize and
    distribute it for the purpose of operating, promoting and marketing the platform. This
    licence continues for as long as Your Content remains on the platform and for a
    reasonable period afterwards for backup and archival purposes.
  </p>
  <p>
    You confirm that you own Your Content or have all necessary rights to grant this
    licence, and that Your Content does not infringe the rights of any third party.
  </p>

  <h3>7.3 Accuracy of listings</h3>
  <p>
    Listing information (including descriptions, photographs, tariffs, amenities and
    availability) is supplied by hosts. Availability data may additionally be imported
    from a host's external calendar feed (for example, an Airbnb iCal link) and is
    synchronised periodically. Such data may therefore be out of date at the moment you
    view it. <strong>We do not verify the ongoing accuracy of listing information and make
    no warranty about it.</strong> Please confirm all details directly with the host before
    making any commitment or payment.
  </p>

  <h2>8. Fees and payments</h2>
  <p>
    Browsing JaipurBnB and contacting hosts is <strong>free for guests</strong>. Hosts pay a
    pre-paid subscription fee to keep a listing live, on the plans published on the
    platform at the time of purchase. All fees are quoted in Indian Rupees (INR) and are
    inclusive of applicable taxes unless stated otherwise.
  </p>
  <p>
    Payments are processed by <strong>Razorpay Software Private Limited</strong>, a payment
    aggregator authorised by the Reserve Bank of India. JaipurBnB does not collect, see or
    store your full card number, CVV or UPI credentials. Your use of Razorpay is also
    subject to Razorpay's own terms and privacy policy.
  </p>
  <p>
    Refunds are governed by our <a href="{{ route('legal.refund') }}">Refund &amp;
    Cancellation Policy</a>. Detailed subscription terms for hosts are set out in the
    <a href="{{ route('legal.host-terms') }}">Host Listing Terms</a>.
  </p>

  <h2>9. Disclaimers and limitation of liability</h2>
  <p>
    The platform is provided on an <strong>“as is” and “as available”</strong> basis. To the
    fullest extent permitted by applicable law, JaipurBnB disclaims all warranties, express
    or implied, including any implied warranty of merchantability, fitness for a particular
    purpose, accuracy or non-infringement.
  </p>
  <p>We specifically do not warrant that:</p>
  <ul>
    <li>any listing is accurate, complete, current or lawful;</li>
    <li>any property is safe, habitable, licensed, insured, or as described;</li>
    <li>any host or guest is who they claim to be, or will perform as promised;</li>
    <li>the platform will be uninterrupted, timely, secure or error-free.</li>
  </ul>

  <div class="jb-legal__callout">
    <p>
      <strong>Stays are arranged directly between guests and hosts.</strong> JaipurBnB is
      not responsible for, and expressly disclaims liability for: the condition, safety,
      legality or quality of any property; the conduct of any host or guest; any injury,
      loss, theft or damage suffered during a stay; any payment made directly to a host;
      any cancellation, no-show or overbooking; or any dispute between a guest and a host.
    </p>
  </div>

  <p>
    To the maximum extent permitted by law, JaipurBnB, its founders, employees and agents
    shall not be liable for any indirect, incidental, special, consequential, punitive or
    exemplary damages, or for any loss of profits, revenue, data, goodwill or business
    opportunity, arising out of or in connection with your use of the platform.
  </p>
  <p>
    Where liability cannot lawfully be excluded, <strong>our total aggregate liability to
    you for all claims arising out of or in connection with the platform shall not exceed
    the amount of subscription fees actually paid by you to JaipurBnB in the twelve (12)
    months immediately preceding the event giving rise to the claim</strong>, or Rs 1,000,
    whichever is higher. Guests, who pay JaipurBnB nothing, acknowledge that this cap is
    Rs 1,000.
  </p>
  <p>
    Nothing in these Terms excludes or limits liability that cannot be excluded or limited
    under applicable Indian law, including liability for fraud or for death or personal
    injury caused by proven gross negligence.
  </p>

  <h2>10. Indemnity</h2>
  <p>
    You agree to indemnify, defend and hold harmless JaipurBnB and its founders, employees
    and agents from and against any claim, demand, proceeding, loss, liability, damage,
    cost or expense (including reasonable legal fees) arising out of or in connection with:
    (a) your breach of these Terms or any applicable law; (b) Your Content; (c) your listing
    or operation of any property; or (d) any dispute between you and another user of the
    platform.
  </p>

  <h2>11. Suspension and termination</h2>
  <p>
    We may suspend or terminate your access to the platform, or remove any listing, with
    immediate effect and without prior notice, where we reasonably believe that you have
    breached these Terms, that a listing is fraudulent or unlawful, or that continued
    access poses a risk to other users or to JaipurBnB.
  </p>
  <p>
    You may close your host account at any time by writing to us. Closing an account does
    not by itself create a right to a refund; refunds are governed solely by the
    <a href="{{ route('legal.refund') }}">Refund &amp; Cancellation Policy</a>.
  </p>
  <p>
    Sections 7, 9, 10, 13 and 14 survive termination of your relationship with JaipurBnB.
  </p>

  <h2>12. Grievance redressal</h2>
  <p>
    In accordance with the Information Technology Act, 2000 and the Information Technology
    (Intermediary Guidelines and Digital Media Ethics Code) Rules, 2021, and with the
    Consumer Protection (E-Commerce) Rules, 2020, complaints regarding content on the
    platform or your use of it may be sent to our Grievance Officer:
  </p>
  <div class="jb-legal__callout">
    <p>
      <strong>Saurabh Kayal</strong>, Grievance Officer, JaipurBNB<br>
      Email: <a href="mailto:saurabhkay95@gmail.com" style="text-transform:none;">saurabhkay95@gmail.com</a><br>
      Phone: <a href="tel:{{ config('contact.phone_tel') }}">{{ config('contact.phone') }}</a> (Monday to Saturday, 10am to 7pm IST)<br>
      Address: 401, Kings Avenue, Kings Road, Nirman Nagar AB, Jaipur, Rajasthan 302019, India
    </p>
    <p>
      We will acknowledge your complaint within <strong>24 hours</strong> and endeavour to
      resolve it within <strong>15 days</strong> of receipt.
    </p>
  </div>

  <h2>13. Dispute resolution</h2>
  <p>
    If a dispute arises between you and JaipurBnB, we ask that you first raise it with our
    Grievance Officer so that we can attempt to resolve it amicably. If the dispute is not
    resolved within thirty (30) days of that notice, it shall be referred to and finally
    resolved by <strong>arbitration under the Arbitration and Conciliation Act, 1996</strong>.
  </p>
  <ul>
    <li>The arbitration shall be conducted by a <strong>sole arbitrator</strong> appointed by mutual agreement between the parties.</li>
    <li>The <strong>seat and venue</strong> of arbitration shall be <strong>Jaipur, Rajasthan</strong>.</li>
    <li>The language of the arbitration shall be <strong>English</strong>.</li>
    <li>The arbitral award shall be final and binding on the parties.</li>
  </ul>
  <p>
    Nothing in this section prevents either party from seeking urgent interim or injunctive
    relief from a competent court.
  </p>
  <p>
    <strong>Disputes between a guest and a host</strong> concerning a stay are not disputes
    with JaipurBnB and are not covered by this section. Those parties must resolve such
    matters between themselves.
  </p>

  <h2>14. Governing law and jurisdiction</h2>
  <p>
    These Terms and any dispute arising out of them are governed by and construed in
    accordance with the <strong>laws of India</strong>. Subject to the arbitration clause in
    section 13, the courts at <strong>Jaipur, Rajasthan</strong> shall have exclusive
    jurisdiction.
  </p>

  <h2>15. Changes to these terms</h2>
  <p>
    We may amend these Terms from time to time to reflect changes in our services or in
    applicable law. The revised version will be posted on this page with an updated “Last
    updated” date. Material changes affecting hosts will additionally be notified by email
    to the address registered on the host account. Your continued use of the platform after
    a change takes effect constitutes acceptance of the revised Terms.
  </p>

  <h2>16. General</h2>
  <p>
    If any provision of these Terms is held to be invalid or unenforceable, that provision
    shall be severed and the remaining provisions shall continue in full force. Our failure
    to enforce any right or provision is not a waiver of that right or provision. These
    Terms, together with the policies referred to in them, constitute the entire agreement
    between you and JaipurBnB in relation to the platform.
  </p>

@endsection
