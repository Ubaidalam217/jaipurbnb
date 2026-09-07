{{--
  Privacy Policy. Written against the Indian DPDP Act 2023 + IT Act 2000 /
  SPDI Rules 2011. Data categories below mirror what the app actually stores:
  users (name, email, phone, password hash), properties, property_images,
  property_availability, transactions (Razorpay ids) and lead_analytics
  (whatsapp_click / call_click / profile_view). Keep this in sync if the
  schema changes.
--}}
@extends('layouts.legal', [
  'pageTitle' => 'Privacy Policy',
  'pageIntro' => 'How JaipurBnB collects, uses, shares and protects your personal data, and the rights you have over it under Indian law.',
])

@section('legal_body')

  <h2>1. Introduction</h2>
  <p>
    This Privacy Policy explains how <strong>JaipurBNB</strong> (“we”, “us”, “our”) handles
    personal data collected through <strong>jaipurbnb.com</strong>. It should be read
    together with our <a href="{{ route('legal.terms') }}">Terms &amp; Conditions</a>.
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
    We process personal data in accordance with the
    <strong>Digital Personal Data Protection Act, 2023</strong>, the
    <strong>Information Technology Act, 2000</strong> and the Information Technology
    (Reasonable Security Practices and Procedures and Sensitive Personal Data or
    Information) Rules, 2011. For the purposes of the DPDP Act, JaipurBnB is the
    <strong>Data Fiduciary</strong> and you are the <strong>Data Principal</strong>.
  </p>

  <h2>2. What data we collect</h2>

  <h3>2.1 Data you give us directly</h3>
  <ul>
    <li><strong>Host account details</strong>, full name, email address, mobile number and a password (stored only as a one-way cryptographic hash, never in readable form).</li>
    <li><strong>Property listing details</strong>, property title, description, neighbourhood, address, stay type, tariff, amenities, house rules and up to fifteen photographs per listing.</li>
    <li><strong>Contact number for guest enquiries</strong>, the mobile number you nominate is displayed to guests on your listing so they can reach you by WhatsApp or call.</li>
    <li><strong>Calendar feed URL</strong>, if you choose to connect an external availability calendar (for example an Airbnb iCal link), we store that URL in order to read availability from it.</li>
    <li><strong>Correspondence</strong>, anything you send us by email or telephone.</li>
  </ul>

  <h3>2.2 Data we collect automatically</h3>
  <ul>
    <li><strong>Listing engagement data</strong>, when a visitor views a listing page or taps its WhatsApp or Call button, we record the event type and time so hosts can see how their listing is performing. These records are used for aggregate counts shown in the host dashboard.</li>
    <li><strong>Technical data</strong>, IP address, browser type and version, device type, operating system, referring page and pages visited, collected through standard server logs.</li>
    <li><strong>Session data</strong>, a session identifier used to keep you logged in.</li>
  </ul>

  <h3>2.3 Data we do not collect</h3>
  <div class="jb-legal__callout">
    <p>
      <strong>We never collect or store your card number, CVV, UPI PIN, net-banking
      credentials or bank account details.</strong> All payment credentials are captured
      directly by our payment gateway on its own secure infrastructure and are never
      transmitted to or held by JaipurBnB.
    </p>
  </div>
  <p>
    We also do not knowingly collect data from children. The platform is intended for users
    aged 18 and above. If you believe a child has provided us with personal data, please
    contact us and we will delete it.
  </p>

  <h2>3. Why we use your data and on what basis</h2>
  <p>
    We process personal data for the following purposes, on the basis of the consent you
    give when you create an account or submit a listing, and for the legitimate uses
    permitted under section 7 of the DPDP Act, 2023:
  </p>
  <ul>
    <li><strong>To provide the service</strong>, create and authenticate your account, publish your listing, and display your contact details to prospective guests.</li>
    <li><strong>To verify listings</strong>, our team manually reviews each submitted listing before it goes live, as described in the <a href="{{ route('legal.host-terms') }}">Host Listing Terms</a>.</li>
    <li><strong>To process subscription payments</strong>, take payment for listing plans and maintain a record of transactions.</li>
    <li><strong>To provide analytics to hosts</strong>, show you how many people viewed your listing and tapped through to contact you.</li>
    <li><strong>To communicate with you</strong>, send transactional emails such as listing approval or rejection notices, payment confirmations, expiry reminders and password reset links.</li>
    <li><strong>To keep the platform secure</strong>, detect and prevent fraud, abuse, spam and unauthorised access.</li>
    <li><strong>To comply with law</strong>, meet our obligations under Indian tax, accounting and information technology law, and respond to lawful requests from authorities.</li>
  </ul>
  <p>
    We do not sell your personal data, and we do not use it to serve third-party
    advertising.
  </p>

  <h2>4. Cookies and similar technologies</h2>
  <p>We use a small number of browser cookies. We do not use advertising or cross-site tracking cookies.</p>
  <ul>
    <li><strong>Strictly necessary cookies</strong>, a session cookie that keeps you signed in, and a CSRF token cookie that protects forms against cross-site request forgery. The platform cannot function without these.</li>
    <li><strong>Preference cookies</strong>, remember choices such as filters you have applied while browsing.</li>
    <li><strong>Payment gateway cookies</strong>, set by Razorpay when a payment window is opened, to secure and complete that transaction.</li>
  </ul>
  <p>
    Most browsers let you refuse or delete cookies through their settings. Blocking
    strictly necessary cookies will prevent you from logging in or submitting forms.
  </p>

  <h2>5. Third-party services we share data with</h2>
  <p>
    We share personal data only where it is necessary to run the platform, and only with
    the following categories of recipient:
  </p>

  <h3>5.1 Razorpay (payments)</h3>
  <p>
    Subscription payments are processed by <strong>Razorpay Software Private Limited</strong>,
    a payment aggregator authorised by the Reserve Bank of India. When you pay for a
    listing plan, your name, email address and mobile number are passed to Razorpay to
    create the payment order, and you enter your payment credentials directly on Razorpay's
    interface. Razorpay returns to us only a payment identifier, an order identifier, the
    amount and the payment status, which we store in our transaction records. Razorpay
    processes your data as an independent data fiduciary under its own privacy policy,
    available at <a href="https://razorpay.com/privacy/" target="_blank" rel="noopener noreferrer">razorpay.com/privacy</a>.
  </p>

  <h3>5.2 Hosting and infrastructure</h3>
  <p>
    The platform and its database are hosted on servers operated by our hosting provider.
    Data is stored on servers located in India wherever the provider offers that option.
  </p>

  <h3>5.3 Email delivery</h3>
  <p>
    Transactional emails are sent through an email service provider, which processes the
    recipient address and message content solely to deliver the message.
  </p>

  <h3>5.4 External calendar providers</h3>
  <p>
    If you supply an external calendar feed URL, our servers fetch that URL periodically to
    read availability dates. This is a <strong>one-way read</strong>: we never write, push
    or send any data back to that provider.
  </p>

  <h3>5.5 Other hosts and guests</h3>
  <p>
    Information you choose to publish in a listing (including your nominated contact
    number, property photographs and the property's neighbourhood) is
    <strong>publicly visible</strong> to anyone browsing the platform. Please do not include
    anything in a listing that you would not want to be public.
  </p>

  <h3>5.6 Legal disclosures</h3>
  <p>
    We may disclose personal data where required to do so by law, court order or a lawful
    request from a government or regulatory authority, or where necessary to establish,
    exercise or defend legal claims.
  </p>

  <h2>6. How long we keep your data</h2>
  <ul>
    <li><strong>Host account and listing data</strong>, for as long as your account is open. If a subscription expires, the listing is hidden from public view but its data is retained so that you can renew and restore it.</li>
    <li><strong>Transaction records</strong>, retained for a minimum of eight (8) years, to meet Indian tax and accounting record-keeping requirements.</li>
    <li><strong>Listing engagement records</strong>, retained while the listing exists so that historical performance remains visible to the host.</li>
    <li><strong>Server logs</strong>, typically retained for a short period for security and diagnostic purposes.</li>
  </ul>
  <p>
    When you ask us to erase your account, we delete or irreversibly anonymise your personal
    data except where we are required by law to retain it (most commonly, transaction and
    tax records).
  </p>

  <h2>7. Your rights</h2>
  <p>As a Data Principal under the DPDP Act, 2023, you have the right to:</p>
  <ul>
    <li><strong>Access</strong>, obtain a summary of the personal data we hold about you and how it is processed.</li>
    <li><strong>Correction</strong>, have inaccurate or incomplete data corrected, completed or updated. Hosts can edit most of their data directly from the host dashboard.</li>
    <li><strong>Erasure</strong>, ask us to delete personal data that is no longer needed for the purpose it was collected, subject to our legal retention obligations.</li>
    <li><strong>Withdraw consent</strong>, withdraw consent you have given, at any time. Withdrawing consent does not affect processing carried out before the withdrawal, and may mean we can no longer keep your listing live.</li>
    <li><strong>Grievance redressal</strong>, raise a complaint with us about how we handle your data (see section 10).</li>
    <li><strong>Nominate</strong>, nominate another individual to exercise your rights in the event of your death or incapacity.</li>
  </ul>
  <p>
    To exercise any of these rights, email
    <a href="mailto:{{ config('contact.email') }}" style="text-transform:none;">{{ config('contact.email') }}</a>
    from the address registered on your account. We may ask you to verify your identity
    before acting on a request, and will respond within the timelines prescribed by law.
  </p>

  <h2>8. How we protect your data</h2>
  <p>We apply reasonable security practices and procedures, including:</p>
  <ul>
    <li>encryption of data in transit using HTTPS/TLS across the whole site;</li>
    <li>one-way hashing of account passwords, so that they cannot be read even by us;</li>
    <li>protection of all state-changing forms with CSRF tokens;</li>
    <li>rate limiting on login, registration and password reset endpoints to blunt automated attacks;</li>
    <li>cryptographic signature verification of every payment callback received from the gateway;</li>
    <li>restricting access to production data to the minimum number of authorised personnel.</li>
  </ul>
  <p>
    No method of transmission or storage is completely secure, and we cannot guarantee
    absolute security. If a personal data breach occurs, we will notify the Data Protection
    Board of India and affected users in the manner and within the timelines required by
    the DPDP Act, 2023.
  </p>

  <h2>9. Changes to this policy</h2>
  <p>
    We may update this Privacy Policy to reflect changes in our practices or in applicable
    law. The revised version will be posted on this page with a new “Last updated” date, and
    material changes will additionally be notified by email to registered hosts.
  </p>

  <h2>10. Grievance Officer</h2>
  <p>
    In accordance with the Information Technology Act, 2000 and the rules made under it, and
    with the DPDP Act, 2023, complaints about the processing of your personal data may be
    addressed to:
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
      resolve it within <strong>15 days</strong>. If you remain dissatisfied, you may
      escalate the matter to the Data Protection Board of India.
    </p>
  </div>

@endsection
