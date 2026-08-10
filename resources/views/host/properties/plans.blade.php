@extends('layouts.base', ['logo5' => true])

@section('title', 'Choose a Plan - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')

  <style>
    .jb-plans {
      --jb-primary: #E07A5F;
      --jb-cta: #B34D33;
      --jb-cta-hover: #8F3D28;
      --jb-ink: #2F3E46;
      --jb-muted: #6B7A82;
      --jb-border: rgba(47, 62, 70, .14);
      font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
      max-width: 1120px;
      margin: 0 auto;
      padding: 56px 20px 80px;
    }

    .jb-plans__head { text-align: center; margin-bottom: 40px; }

    .jb-plans__eyebrow {
      display: inline-block;
      padding: 6px 14px;
      border-radius: 999px;
      background: rgba(224, 122, 95, .14);
      color: var(--jb-cta);
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .04em;
      text-transform: uppercase;
    }

    .jb-plans__title {
      margin: 16px 0 8px;
      color: var(--jb-ink);
      font-size: 34px;
      font-weight: 700;
      line-height: 1.2;
    }

    .jb-plans__property { color: var(--jb-cta); }

    .jb-plans__sub { margin: 0; color: var(--jb-muted); font-size: 16px; line-height: 1.6; }

    .jb-plans__grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      align-items: start;
    }

    .jb-plan {
      display: flex;
      flex-direction: column;
      padding: 32px 26px;
      border: 1px solid var(--jb-border);
      border-radius: 16px;
      background: #fff;
      height: 100%;
    }

    .jb-plan--popular {
      border-color: var(--jb-primary);
      border-width: 2px;
      box-shadow: 0 12px 34px rgba(224, 122, 95, .16);
    }

    .jb-plan__flag {
      align-self: flex-start;
      margin-bottom: 12px;
      padding: 5px 12px;
      border-radius: 999px;
      background: var(--jb-primary);
      color: #fff;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: .04em;
      text-transform: uppercase;
    }

    .jb-plan__name { margin: 0; color: var(--jb-ink); font-size: 21px; font-weight: 700; }
    .jb-plan__tagline { margin: 4px 0 20px; color: var(--jb-muted); font-size: 14px; }

    .jb-plan__price { display: flex; align-items: baseline; gap: 6px; color: var(--jb-ink); }
    .jb-plan__amount { font-size: 38px; font-weight: 700; line-height: 1; }
    .jb-plan__per { color: var(--jb-muted); font-size: 15px; }

    .jb-plan__perday {
      margin: 10px 0 22px;
      padding: 8px 12px;
      border-radius: 8px;
      background: rgba(47, 62, 70, .05);
      color: var(--jb-muted);
      font-size: 13.5px;
    }

    .jb-plan__features { flex: 1; margin: 0 0 24px; padding: 0; list-style: none; }

    .jb-plan__features li {
      position: relative;
      margin-bottom: 11px;
      padding-left: 26px;
      color: var(--jb-ink);
      font-size: 14.5px;
      line-height: 1.5;
    }

    .jb-plan__features li::before {
      content: "✓";
      position: absolute;
      left: 0;
      top: -1px;
      color: var(--jb-cta);
      font-weight: 700;
    }

    .jb-plan__btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      min-height: 50px;
      padding: 0 20px;
      border: 0;
      border-radius: 10px;
      background: var(--jb-cta);
      color: #fff;
      font-family: inherit;
      font-size: 15.5px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color .2s ease;
    }

    .jb-plan__btn:hover:not(:disabled) { background: var(--jb-cta-hover); }
    .jb-plan__btn:disabled { opacity: .65; cursor: progress; }

    .jb-plans__note {
      margin-top: 34px;
      text-align: center;
      color: var(--jb-muted);
      font-size: 14px;
    }

    .jb-plans__alert {
      max-width: 640px;
      margin: 0 auto 28px;
      padding: 14px 18px;
      border: 1px solid rgba(179, 77, 51, .3);
      border-radius: 10px;
      background: rgba(224, 122, 95, .1);
      color: #8F3D28;
      font-size: 14.5px;
      text-align: center;
    }

    .jb-plans__founding {
      max-width: 640px;
      margin: 0 auto 28px;
      padding: 14px 18px;
      border: 1px solid rgba(15, 138, 122, .3);
      border-radius: 10px;
      background: rgba(15, 138, 122, .1);
      color: #0F6B60;
      font-size: 14.5px;
      text-align: center;
    }

    @media (max-width: 991.98px) {
      .jb-plans__grid { grid-template-columns: 1fr; max-width: 460px; margin: 0 auto; }
      .jb-plans__title { font-size: 27px; }
      .jb-plans { padding: 36px 16px 60px; }
    }
  </style>

  <div class="jb-plans">
    @if ($property->isFoundingHostActive())
      <div class="jb-plans__founding" role="status">
        You are a Founding Host! Your listing is free until {{ $property->host->founding_host_expires_at->format('d M Y') }}.
        You only need to subscribe after this date to keep it live.
      </div>
    @endif

    <div class="jb-plans__head">
      <span class="jb-plans__eyebrow">Publish your listing</span>
      <h1 class="jb-plans__title">
        Choose a plan for:<br><span class="jb-plans__property">{{ $property->title }}</span>
      </h1>
      <p class="jb-plans__sub">
        @if ($property->subscriptionHasExpired())
          Your subscription ended on {{ $property->subscription_expiry->format('d M Y') }}. Renew to put this listing back in front of guests.
        @else
          Your listing is approved. Pick a duration to make it visible to guests.
        @endif
      </p>
    </div>

    @if (session('error'))
      <div class="jb-plans__alert" role="alert">{{ session('error') }}</div>
    @endif
    <div class="jb-plans__alert" id="jb-pay-error" role="alert" style="display:none;"></div>

    <div class="jb-plans__grid">
      @foreach ($plans as $plan)
        <div class="jb-plan {{ $plan['popular'] ? 'jb-plan--popular' : '' }}">
          @if ($plan['popular'])
            <span class="jb-plan__flag">Most popular</span>
          @endif

          <h2 class="jb-plan__name">{{ $plan['name'] }}</h2>
          <p class="jb-plan__tagline">{{ $plan['tagline'] }}</p>

          <div class="jb-plan__price">
            <span class="jb-plan__amount">Rs {{ number_format($plan['price']) }}</span>
            <span class="jb-plan__per">/ {{ $plan['days'] }} days</span>
          </div>

          <p class="jb-plan__perday">Works out at about Rs {{ $plan['price_per_day'] }} per day</p>

          <ul class="jb-plan__features">
            @foreach ($plan['features'] as $feature)
              <li>{{ $feature }}</li>
            @endforeach
          </ul>

          <button class="jb-plan__btn" type="button"
                  data-jb-subscribe
                  data-duration="{{ $plan['days'] }}"
                  data-label="{{ $plan['name'] }}">
            Subscribe Now
          </button>
        </div>
      @endforeach
    </div>

    <p class="jb-plans__note">
      Secure payment via Razorpay. Cards, UPI, net banking and wallets accepted.<br>
      We never see or store your card details.
    </p>
  </div>

  {{-- Razorpay posts the verified payment back through this form so the
       browser follows the redirect normally. Built server-side so the CSRF
       token is a real Blade-issued one, not something assembled in JS. --}}
  <form method="POST" action="{{ route('host.properties.verify', $property) }}" id="jb-verify-form" hidden>
    @csrf
    <input type="hidden" name="razorpay_order_id" id="jb-order-id">
    <input type="hidden" name="razorpay_payment_id" id="jb-payment-id">
    <input type="hidden" name="razorpay_signature" id="jb-signature">
    <input type="hidden" name="duration" id="jb-duration">
  </form>
@endsection

@section('scripts')
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    (function () {
      var orderUrl  = @json(route('host.properties.order', $property));
      var failedUrl = @json(route('host.properties.failed', $property));
      var csrf      = @json(csrf_token());
      var prefill   = {
        name:    @json($property->host->name),
        email:   @json($property->host->email),
        contact: @json($property->host->phone_number ?? '')
      };

      var errorBox = document.getElementById('jb-pay-error');

      function showError(message) {
        errorBox.textContent = message;
        errorBox.style.display = 'block';
        errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }

      function resetButtons() {
        document.querySelectorAll('[data-jb-subscribe]').forEach(function (b) {
          b.disabled = false;
          b.textContent = 'Subscribe Now';
        });
      }

      document.querySelectorAll('[data-jb-subscribe]').forEach(function (button) {
        button.addEventListener('click', function () {
          var duration = button.dataset.duration;

          errorBox.style.display = 'none';
          button.disabled = true;
          button.textContent = 'Starting payment…';

          // Step 1: ask our server for a Razorpay order. The price is never
          // sent from here - the server looks it up from the duration.
          fetch(orderUrl, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ duration: Number(duration) })
          })
            .then(function (res) { return res.json().then(function (b) { return { ok: res.ok, body: b }; }); })
            .then(function (r) {
              if (!r.ok || !r.body.ok) {
                throw new Error(r.body && r.body.message ? r.body.message : 'We could not start the payment.');
              }
              openCheckout(r.body);
            })
            .catch(function (err) {
              resetButtons();
              showError(err.message || 'Something went wrong starting the payment. Please try again.');
            });
        });
      });

      // Step 2: hand the order to Razorpay's modal.
      function openCheckout(order) {
        if (typeof Razorpay === 'undefined') {
          resetButtons();
          showError('The payment library did not load. Check your connection and try again.');
          return;
        }

        var rzp = new Razorpay({
          key: order.key_id,
          amount: order.amount,
          currency: order.currency,
          name: order.name,
          description: order.description,
          order_id: order.order_id,
          prefill: prefill,
          theme: { color: '#E07A5F' },
          // Step 3: signature comes back here. We do not trust it in the
          // browser - it is posted to the server, which recomputes the HMAC.
          handler: function (response) {
            document.getElementById('jb-order-id').value   = response.razorpay_order_id;
            document.getElementById('jb-payment-id').value = response.razorpay_payment_id;
            document.getElementById('jb-signature').value  = response.razorpay_signature;
            document.getElementById('jb-duration').value   = order.duration;
            document.getElementById('jb-verify-form').submit();
          },
          modal: {
            ondismiss: function () {
              window.location.href = failedUrl;
            }
          }
        });

        rzp.on('payment.failed', function () {
          window.location.href = failedUrl;
        });

        rzp.open();
        resetButtons();
      }
    })();
  </script>
@endsection
