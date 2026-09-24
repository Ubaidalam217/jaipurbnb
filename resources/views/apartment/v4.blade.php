@extends('layouts.base', ['logo5' => true])

@section('title', 'Browse Jaipur BnB Properties - Heritage Havelis & Boutique Stays in Jaipur')

@section('meta_description', 'Explore verified Jaipur BnB listings by neighborhood, stay type and guests. Amer, Walled City, Nahargarh and more. Direct host contact.')

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

    /* Capacity line: guests / bedrooms / bathrooms from the listing. */
    .apartment-inner2-section-area .apartment-boxarea .content-area .jb-card-capacity {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin: 0 0 14px;
      color: #2F3E46;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      font-weight: 500;
      line-height: 1.4;
    }

    .apartment-inner2-section-area .apartment-boxarea .content-area .jb-card-capacity span[aria-hidden] {
      color: #A9B4BA;
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

    /* ------------------------------------------------------------------ *
     * Equal-height cards.
     *
     * Two things made the grid ragged: (1) .img1 had no fixed height, so
     * each cover cropped to its own aspect ratio; (2) the card did not
     * stretch to the column, so a 2-line title or wrapped capacity row
     * made neighbouring cards different heights. Fix: give every column a
     * fixed image band, then let the card fill the Bootstrap column (which
     * already stretches to the tallest in its row) and let .content-area
     * absorb the slack so the contact row + View arrow sit flush at the
     * bottom of every card.
     * ------------------------------------------------------------------ */
    .apartment-inner2-section-area .jb-card-col {
      display: flex;
      margin-bottom: 24px;
    }

    .apartment-inner2-section-area .jb-card-col .apartment-boxarea {
      display: flex;
      flex-direction: column;
      width: 100%;
      height: 100%;
    }

    /* Uniform cover band. .img1 img is already object-fit:cover + 100%,
       so a fixed container height crops every photo identically. */
    .apartment-inner2-section-area .jb-card-col .apartment-boxarea .img1 {
      height: 240px;
      flex-shrink: 0;
    }

    /* Grow the body so everything below it (contact row, View arrow) is
       pushed to the card's bottom edge, aligning across the row. */
    .apartment-inner2-section-area .jb-card-col .apartment-boxarea .content-area {
      flex: 1 1 auto;
      min-width: 0;
    }

    /* Pet-friendly badge on a browse card. */
    .jb-pet-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      margin: 0 0 10px;
      padding: 3px 10px;
      border-radius: 999px;
      background: rgba(47, 62, 70, .08);
      color: #2F3E46;
      font-family: 'Poppins', sans-serif;
      font-size: 12.5px;
      font-weight: 600;
    }

    .apartment-boxarea .img1 {
      position: relative;
    }

    .jb-result-bar {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin: 0 0 28px;
      padding-bottom: 14px;
      border-bottom: 1px solid rgba(47, 62, 70, .12);
    }

    .jb-result-count {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
      color: #5A6B73;
    }

    .jb-result-count strong {
      color: #2F3E46;
      font-weight: 600;
    }

    .jb-clear-filters {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 8px 16px;
      border: 1px solid rgba(179, 77, 51, .35);
      border-radius: 999px;
      background: rgba(179, 77, 51, .06);
      color: #B34D33;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      font-weight: 600;
      transition: background .25s ease, border-color .25s ease;
    }

    .jb-clear-filters:hover {
      background: rgba(179, 77, 51, .13);
      border-color: rgba(179, 77, 51, .55);
      color: #B34D33;
    }

    /* Date filter inputs - matched to the template's own .nice-select
       height/border rather than jquery-nice-select, which only styles
       <select> elements. */
    .jb-filter-date {
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 4px;
      height: 60px;
      padding: 0 20px;
      border: 1px solid #EAEAEA;
      border-radius: 6px;
      background: #fff;
    }

    .jb-filter-date label {
      margin: 0;
      color: #6B7A82;
      font-family: 'Poppins', sans-serif;
      font-size: 12px;
      font-weight: 500;
    }

    .jb-filter-date input[type="date"] {
      border: 0;
      padding: 0;
      color: #2F3E46;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      background: transparent;
    }

    .jb-filter-date input[type="date"]:focus {
      outline: none;
    }

    .jb-filter-pet {
      display: flex;
      align-items: center;
      height: 60px;
      padding: 0 20px;
      border: 1px solid #EAEAEA;
      border-radius: 6px;
      background: #fff;
    }

    .jb-filter-pet label {
      display: flex;
      align-items: center;
      gap: 8px;
      margin: 0;
      color: #2F3E46;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
    }

    .jb-filter-pet input {
      width: 17px;
      height: 17px;
      accent-color: #E07A5F;
    }

    /*
      Amenity filter checkboxes, grouped by category.

      Layout note: the category label is a block-level heading ABOVE its
      chip row, not an inline flex item beside the first chip. Putting the
      label inside the same flex-wrap row as the chips (the previous
      approach) reads fine on a wide screen where everything fits on one
      line, but on a narrow screen the label ends up sharing a wrapped
      row with only the first chip - visually attaching "Basics" to
      "Air conditioning" alone while every other Basics chip wraps onto
      disconnected lines below. Decoupling the label from the wrap flow
      fixes that at every width, not just desktop.
    */
    .jb-amenity-filter {
      margin-top: 20px;
      padding: 20px 24px;
      border: 1px solid #EAEAEA;
      border-radius: 8px;
      background: #fff;
      /* No overflow/height constraint here on purpose - a fixed height
         or overflow:hidden would clip whichever wrapped chip rows don't
         fit, which is exactly the failure this rule guards against. */
    }

    .jb-amenity-filter__group {
      margin-bottom: 18px;
    }

    .jb-amenity-filter__group:last-child {
      margin-bottom: 0;
    }

    .jb-amenity-filter__label {
      display: block;
      margin: 0 0 10px;
      color: #6B7A82;
      font-family: 'Poppins', sans-serif;
      font-size: 12.5px;
      font-weight: 600;
      letter-spacing: .03em;
      text-transform: uppercase;
    }

    .jb-amenity-filter__chips {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }

    .jb-amenity-chip {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 12px;
      border: 1px solid #EAEAEA;
      border-radius: 999px;
      color: #2F3E46;
      font-family: 'Poppins', sans-serif;
      font-size: 13.5px;
      font-weight: 500;
      line-height: 1.4;
      cursor: pointer;
      transition: border-color .15s ease, background-color .15s ease;
    }

    .jb-amenity-chip:hover {
      border-color: #D8DDE0;
      background: rgba(47, 62, 70, .04);
    }

    .jb-amenity-chip input {
      width: 15px;
      height: 15px;
      accent-color: #E07A5F;
    }

    .jb-amenity-chip:has(input:checked) {
      border-color: #E07A5F;
      background: rgba(224, 122, 95, .1);
    }

    .jb-amenity-chip:has(input:checked):hover {
      border-color: #E07A5F;
      background: rgba(224, 122, 95, .16);
    }

    /* CLS fix: the template's own .img1 img rule is `height:100%` with no
       height set anywhere on .img1 itself, so the card's photo area had no
       reserved size until each card's own image loaded - host photos are
       arbitrary aspect ratios, so every card would also jump a different
       amount, un-aligning the grid row by row as images arrived. A fixed
       aspect-ratio reserves the exact same box up front regardless of the
       source photo's real dimensions, and object-fit:cover (already set)
       crops to fill it. 3:2 matches the site's own cover photos most
       closely (1320x880 is exactly 3:2). */
    .apartment-inner2-section-area .apartment-boxarea .img1 {
      aspect-ratio: 3 / 2;
    }

    .apartment-inner2-section-area .apartment-boxarea .img1 img {
      height: 100%;
      width: 100%;
      object-fit: cover;
    }
  </style>
  <!-- ===== HERO AREA STARTS ======= -->
  <div class="inner-main-hero-area">
    <div class="img1">
    <img src="/img/all-images/hero/hero-img1.png" alt="" width="1448" height="1086" />
    </div>
    <div class="img2">
    <img src="/img/all-images/hero/hero-img2.webp" alt="" width="919" height="800" />
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
      {{--
        Gated on $neighborhoodCount, NOT on $properties->total().

        The box used to be wrapped in @if ($properties->total() > 0), which
        hid the neighborhood count along with everything else the moment a
        filter returned nothing - so the count vanished on exactly the
        pages where "we do cover 5 neighborhoods, widen your filter" is the
        most useful thing to say. The two numbers answer different
        questions: the headline counts the CURRENT result set (and may
        legitimately be 0), the line under it is site-wide coverage.
      --}}
      @if ($neighborhoodCount > 0)
      <div class="auhtor-box">
        <div class="others-box">
        <div class="img3">
          <img src="/img/all-images/others/others-img1.webp" alt="" width="240" height="180" />
        </div>
        <div class="text">
          <h3>{{ $properties->total() }} {{ Str::plural('stay', $properties->total()) }} available</h3>
          <div class="space10"></div>
          {{-- Distinct neighborhoods with a live listing, not count() of the
               22-entry filter menu. Same source as the homepage counter. --}}
          <p>Across {{ $neighborhoodCount }} {{ Str::plural('Jaipur neighborhood', $neighborhoodCount) }}</p>
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
        <select name="guests" class="nice-select">
          <option value="" data-display="Guests">Guests: Any</option>
          @foreach ($guestOptions as $option)
          <option value="{{ $option }}" @selected($filters['guests'] === $option)>{{ $option }}+ guests</option>
          @endforeach
        </select>
        </div>

        <div class="select-area2">
        <select name="bedrooms" class="nice-select">
          <option value="" data-display="Bedrooms">Bedrooms: Any</option>
          @foreach ($bedroomOptions as $option)
          <option value="{{ $option }}" @selected($filters['bedrooms'] === $option)>{{ $option }}+ bedrooms</option>
          @endforeach
        </select>
        </div>

        <div class="jb-filter-date">
        <label for="check_in">Check-in</label>
        <input type="date" name="check_in" id="check_in" value="{{ request('check_in') }}">
        </div>

        <div class="jb-filter-date">
        <label for="check_out">Check-out</label>
        <input type="date" name="check_out" id="check_out" value="{{ request('check_out') }}">
        </div>

        <div class="jb-filter-pet">
        <label for="pet_friendly">
          <input type="checkbox" name="pet_friendly" id="pet_friendly" value="1" @checked($filters['pet_friendly'])>
          Pet-friendly
        </label>
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

    @if ($amenitiesByCategory->isNotEmpty())
    <div class="row">
      <div class="col-lg-12">
        <div class="jb-amenity-filter">
          @foreach ($amenitiesByCategory as $category => $categoryAmenities)
            <div class="jb-amenity-filter__group">
              <span class="jb-amenity-filter__label">{{ $category }}</span>
              <div class="jb-amenity-filter__chips">
                @foreach ($categoryAmenities as $amenity)
                  <label class="jb-amenity-chip">
                    <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" @checked(in_array($amenity->id, $filters['amenities'], true))>
                    @if ($amenity->icon)<i class="{{ $amenity->icon }}" aria-hidden="true"></i>@endif
                    {{ $amenity->name }}
                  </label>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif
    </form>

    {{--
      Result summary + reset. The reset used to live only in the @empty branch
      below, which meant it appeared only when a filter matched nothing; with
      1-9 results there was no way back to the full list. The count is shown
      alongside it so "6 of 6" reads as the complete catalogue rather than
      leaving the guest guessing whether a filter is still on.
    --}}
    <div class="row">
      <div class="col-lg-12">
        <div class="jb-result-bar">
          <p class="jb-result-count">
            @if ($hasActiveFilters)
              Showing <strong>{{ $properties->total() }}</strong> of {{ $totalVisible }}
              {{ Str::plural('property', $totalVisible) }}
            @else
              <strong>{{ $totalVisible }}</strong> {{ Str::plural('property', $totalVisible) }} available
            @endif
          </p>
          @if ($hasActiveFilters)
            <a href="{{ route('properties.browse') }}" class="jb-clear-filters">
              <i class="fa-solid fa-xmark" aria-hidden="true"></i> Clear all filters
            </a>
          @endif
        </div>
      </div>
    </div>

    <div class="row">
      @forelse ($properties as $property)
      <div class="col-lg-4 col-md-6 jb-card-col" data-aos="zoom-in-up" data-aos-duration="800">
      <div class="apartment-boxarea">
        {{-- The photo is the biggest click target on the card, so it has to
             open the listing. It was previously a bare <img> with no anchor:
             only the title, price and "View" arrow were clickable. --}}
        <div class="img1">
        <a href="{{ route('properties.show', $property) }}" style="display:block;" aria-label="View {{ $property->title }}">
        @if ($property->coverImage)
        <img src="{{ $property->coverImage->display_url }}" alt="{{ $property->title }}" />
        @else
        <img src="/img/all-images/apartment/apartment-img1.webp" alt="{{ $property->title }}" width="1110" height="740" />
        @endif
        </a>
        </div>
        <div class="content-area">
        <div class="jb-card-title">
          <a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a>
        </div>
        <p class="jb-card-stay-type">{{ $property->stay_type }}</p>
        @if ($property->is_pet_friendly)
        <span class="jb-pet-badge"><i class="fa-solid fa-paw" aria-hidden="true"></i> Pet-friendly</span>
        @endif
        {{-- Real capacity, not the template's hardcoded "2 BR / 2 BA". --}}
        <p class="jb-card-capacity">
          <span>{{ $property->max_guests }} {{ Str::plural('guest', $property->max_guests) }}</span>
          <span aria-hidden="true">&middot;</span>
          <span>{{ $property->bedrooms }} {{ Str::plural('bedroom', $property->bedrooms) }}</span>
          <span aria-hidden="true">&middot;</span>
          <span>{{ $property->bathrooms }} {{ Str::plural('bathroom', $property->bathrooms) }}</span>
        </p>
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
        <img src="/img/all-images/service/service-img4.webp" alt="" width="480" height="344" />
        </div>
        <div class="space32"></div>
        <div class="content-area">
        <a href="{{ route('properties.browse') }}">Reviewed Listings</a>
        <div class="space18"></div>
        <p>
          Every listing is reviewed by our team <br class="d-lg-block d-block" /> before it goes live.
        </p>
        <h3>01</h3>
        </div>
      </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="zoom-in-up" data-aos-duration="1000">
      <div class="space40 d-lg-block d-none"></div>
      <div class="amenities-boxarea">
        <div class="img1">
        <img src="/img/all-images/service/service-img5.webp" alt="" width="396" height="316" />
        </div>
        <div class="space32"></div>
        <div class="content-area">
        <a href="{{ route('properties.browse') }}">Local Support</a>
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
        <img src="/img/all-images/service/service-img7.webp" alt="" width="480" height="360" />
        </div>
        <div class="space32"></div>
        <div class="content-area">
        <a href="{{ route('properties.browse') }}">Airport Pickup</a>
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
        <img src="/img/all-images/service/service-img8.webp" alt="" width="480" height="360" />
        </div>
        <div class="space32"></div>
        <div class="content-area">
        <a href="{{ route('properties.browse') }}">Home-Cooked Meals</a>
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
