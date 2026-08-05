@extends('layouts.base', ['logo5' => true])

@section('title', 'Browse Properties in Jaipur - JaipurBnB')

@section('content')
  @include('layouts.partials.navbar')
  {{--
    Browse-card content styling.

    SPECIFICITY: these selectors deliberately repeat the template's own
    ancestor chain. The template styles bare <a> descendants of
    .content-area at (0,3,1):

      .apartment-inner2-section-area .apartment-boxarea .content-area a
          { color:...; font-size:20px; font-weight:bold; display:inline-block }

    so a lone `.jb-card-price` (0,1,0) loses and the price badge renders
    as 20px bold body text instead of a compact chip. Repeating the chain
    and appending our own class scores (0,4,1), which wins cleanly with
    no !important. The same rule is why the contact buttons are rendered
    as a SIBLING of .content-area rather than inside it - see the
    matching note in contact-buttons.blade.php.

    Related template landmine: `.content-area ul li span { color:#EDEDEE }`
    was written for a separator dot, so reusing that markup for the stay
    type made it near-white on white. Hence the dedicated <p> below.
  --}}
  <style>
    .apartment-inner2-section-area .apartment-boxarea .content-area {
      /* The contact row supplies the card's bottom padding now. */
      padding-bottom: 18px;
    }

    .apartment-inner2-section-area .apartment-boxarea .content-area .jb-card-title {
      margin: 0 0 4px;
    }

    .apartment-inner2-section-area .apartment-boxarea .content-area .jb-card-title a {
      display: block;
      color: #2F3E46;
      font-family: 'Poppins', sans-serif;
      font-size: 20px;
      font-weight: 700;
      line-height: 1.35;
      text-decoration: none;
    }

    .apartment-inner2-section-area .apartment-boxarea .content-area .jb-card-title a:hover {
      color: #B34D33;
      text-decoration: none;
    }

    .apartment-inner2-section-area .apartment-boxarea .content-area .jb-card-stay-type {
      margin: 0 0 14px;
      color: #6B7A82;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      font-weight: 500;
      line-height: 1.4;
    }

    .apartment-inner2-section-area .apartment-boxarea .content-area .jb-card-meta {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    .apartment-inner2-section-area .apartment-boxarea .content-area a.jb-card-price {
      display: inline-flex;
      align-items: center;
      padding: 9px 14px;
      border-radius: 8px;
      background: rgba(224, 122, 95, .12);
      color: #B34D33;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      font-weight: 600;
      line-height: 1;
      text-decoration: none;
      white-space: nowrap;
    }

    .apartment-inner2-section-area .apartment-boxarea .content-area a.jb-card-price:hover {
      background: rgba(224, 122, 95, .2);
      color: #B34D33;
      text-decoration: none;
    }

    .apartment-inner2-section-area .apartment-boxarea .content-area .jb-card-neighborhood {
      /* margin-left:auto pins it right even if the row wraps. */
      margin-left: auto;
      color: #6B7A82;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      font-weight: 500;
      text-align: right;
    }

    /* Sibling of .content-area, so it carries the card's own side padding
       (matching .content-area's 32px / 15px) instead of inheriting it. */
    .jb-card-contact {
      padding: 16px 32px 24px;
      border-top: 1px solid rgba(47, 62, 70, .08);
    }

    @media (max-width: 767px) {
      .jb-card-contact {
        padding: 16px 15px 24px;
      }
    }
  </style>
  <!-- ===== HERO AREA STARTS ======= -->
  <div class="inner-main-hero-area">
    <div class="img1">
    <img src="/img/all-images/hero/hero-img1.png" alt="" />
    </div>
    <div class="img2">
    <img src="/img/all-images/hero/hero-img2.png" alt="" />
    </div>
    <div class="container">
    <div class="row">
      <div class="col-lg-5">
      <div class="inner-heading header-heading">
        <h2>Browse Properties in Jaipur</h2>
        <div class="space24"></div>
        <p>
        <a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> <a href="{{ route('properties.browse') }}">Browse Properties</a>
        </p>
      </div>
      </div>
      <div class="col-lg-2"></div>
      <div class="col-lg-4">
      @if ($properties->total() > 0)
      <div class="auhtor-box">
        <div class="others-box">
        <div class="img3">
          <img src="/img/all-images/others/others-img1.png" alt="" />
        </div>
        <div class="text">
          <h3>{{ $properties->total() }} {{ Str::plural('stay', $properties->total()) }} available</h3>
          <div class="space10"></div>
          <p>Across {{ count($neighborhoods) }} Jaipur neighborhoods</p>
        </div>
        </div>
      </div>
      @endif
      </div>
    </div>
    </div>
  </div>
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== APARTMENT AREA STARTS ======= -->
  <div class="apartment-inner2-section-area sp7 bg2">
    <div class="container">
    {{--
      Filter bar. GET so results stay linkable and bookmarkable.
      The selects are styled by jquery-nice-select (resources/js/main.js),
      which keeps the underlying native <select> in sync, so a plain
      submit carries the real values.
    --}}
    <form method="GET" action="{{ route('properties.browse') }}">
    <div class="row">
      <div class="col-lg-12">
      <div class="apartment-list-area space-margin60">
        <div class="select-area">
        <select name="neighborhood" class="nice-select">
          <option value="" data-display="All Neighborhoods">All Neighborhoods</option>
          @foreach ($neighborhoods as $neighborhood)
          <option value="{{ $neighborhood }}" @selected($filters['neighborhood'] === $neighborhood)>{{ $neighborhood }}</option>
          @endforeach
        </select>
        </div>

        <div class="select-area">
        <select name="stay_type" class="nice-select">
          <option value="" data-display="All Stay Types">All Stay Types</option>
          @foreach ($stayTypes as $stayType)
          <option value="{{ $stayType }}" @selected($filters['stay_type'] === $stayType)>{{ $stayType }}</option>
          @endforeach
        </select>
        </div>

        <div class="select-area2">
        <select name="min_price" class="nice-select">
          <option value="" data-display="Min Price">Min Price: Any</option>
          @foreach ([1000, 2000, 3000, 5000, 10000] as $price)
          <option value="{{ $price }}" @selected($filters['min_price'] === $price)>Rs {{ number_format($price) }}+</option>
          @endforeach
        </select>
        </div>

        <div class="select-area2">
        <select name="max_price" class="nice-select">
          <option value="" data-display="Max Price">Max Price: Any</option>
          @foreach ([3000, 5000, 10000, 15000, 25000] as $price)
          <option value="{{ $price }}" @selected($filters['max_price'] === $price)>Up to Rs {{ number_format($price) }}</option>
          @endforeach
        </select>
        </div>

        <div class="select-area2">
        <select name="sort" class="nice-select">
          <option value="newest" @selected($filters['sort'] === 'newest')>Newest First</option>
          <option value="price_low" @selected($filters['sort'] === 'price_low')>Price: Low to High</option>
          <option value="price_high" @selected($filters['sort'] === 'price_high')>Price: High to Low</option>
        </select>
        </div>

        <div class="btn-area1">
        <button type="submit" class="header-btn4">Search Now</button>
        </div>
      </div>
      </div>
    </div>
    </form>

    <div class="row">
      @forelse ($properties as $property)
      <div class="col-lg-4 col-md-6" data-aos="zoom-in-up" data-aos-duration="800">
      <div class="apartment-boxarea">
        <div class="img1">
        @if ($property->coverImage)
        <img src="{{ Storage::url($property->coverImage->image_url) }}" alt="{{ $property->title }}" />
        @else
        <img src="/img/all-images/apartment/apartment-img1.png" alt="{{ $property->title }}" />
        @endif
        </div>
        <div class="content-area">
        <div class="jb-card-title">
          <a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a>
        </div>
        <p class="jb-card-stay-type">{{ $property->stay_type }}</p>
        <div class="jb-card-meta">
          <a href="{{ route('properties.show', $property) }}" class="jb-card-price">Approx Rs {{ number_format($property->approx_price) }} / night</a>
          <span class="jb-card-neighborhood">{{ $property->neighborhood }}</span>
        </div>
        </div>
        {{-- Outside .content-area on purpose: the template's
             `.content-area a` rule would force display:inline-block onto
             the buttons and kill their flex centring. See style block above. --}}
        <div class="jb-card-contact">
          @include('layouts.partials.contact-buttons', ['property' => $property, 'size' => 'sm', 'fullWidth' => true])
        </div>
        <div class="arrow">
        <a href="{{ route('properties.show', $property) }}">View</a>
        </div>
      </div>
      </div>
      @empty
      <div class="col-lg-8 m-auto">
      <div class="heading3 text-center">
        <div class="space30"></div>
        <h3>No properties found matching your filters. Try adjusting your search.</h3>
        <div class="space24"></div>
        <div class="btn-area1">
        <a href="{{ route('properties.browse') }}" class="header-btn4">Clear all filters</a>
        </div>
        <div class="space30"></div>
      </div>
      </div>
      @endforelse

      @if ($properties->hasPages())
      <div class="col-lg-12">
      <div class="space30"></div>
      <div class="pagination-area">
        {{ $properties->links() }}
      </div>
      </div>
      @endif
    </div>
    </div>
  </div>
  <!-- ===== APARTMENT AREA ENDS ======= -->

  <!-- ===== SERVICE AREA STARTS ======= -->
  <div class="service3-section-area sp1">
    <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto">
      <div class="heading3 text-center space-margin60">
        <h5 data-aos="fade-left" data-aos-duration="800">Why JaipurBnB</h5>
        <div class="space20"></div>
        <h2 class="text-anime-style-3">Why Guests Choose Us</h2>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="800">
      <div class="amenities-boxarea">
        <div class="img1">
        <img src="/img/all-images/service/service-img4.png" alt="" />
        </div>
        <div class="space32"></div>
        <div class="content-area">
        <a href="#">Verified Listings</a>
        <div class="space18"></div>
        <p>
          Every property is checked in person <br class="d-lg-block d-block" /> by our Jaipur team.
        </p>
        <h3>01</h3>
        </div>
      </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
      <div class="space40 d-lg-block d-none"></div>
      <div class="amenities-boxarea">
        <div class="img1">
        <img src="/img/all-images/service/service-img5.png" alt="" />
        </div>
        <div class="space32"></div>
        <div class="content-area">
        <a href="#">Local Support</a>
        <div class="space18"></div>
        <p>
          A Jaipur-based team on hand <br class="d-lg-block d-block" /> if anything goes wrong.
        </p>
        <h3>02</h3>
        </div>
      </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="1100">
      <div class="amenities-boxarea">
        <div class="img1">
        <img src="/img/all-images/service/service-img7.png" alt="" />
        </div>
        <div class="space32"></div>
        <div class="content-area">
        <a href="#">Airport Pickup</a>
        <div class="space18"></div>
        <p>
          Many hosts arrange transfers <br class="d-lg-block d-block" /> from Jaipur airport on request.
        </p>
        <h3>03</h3>
        </div>
      </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="1200">
      <div class="space40 d-lg-block d-none"></div>
      <div class="amenities-boxarea">
        <div class="img1">
        <img src="/img/all-images/service/service-img8.png" alt="" />
        </div>
        <div class="space32"></div>
        <div class="content-area">
        <a href="#">Home-Cooked Meals</a>
        <div class="space18"></div>
        <p>
          Traditional Rajasthani cooking <br class="d-lg-block d-block" /> offered by many families.
        </p>
        <h3>04</h3>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  <!-- ===== SERVICE AREA ENDS ======= -->

  @include('layouts.partials.footer')
@endsection
