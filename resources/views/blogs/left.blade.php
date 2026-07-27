@extends('layouts.landing')

@section('content')
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
      <h2>Blog Details</h2>
      <div class="space24"></div>
      <p>
      <a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> <a href="{{ url('/') }}">Our Blog <i class="fa-solid fa-angle-right"></i></a> <a href="{{ url('/blogs/blog') }}"'">Blog Details</a>
      </p>
      </div>
    </div>
    <div class="col-lg-2"></div>
    <div class="col-lg-4">
      <div class="auhtor-box">
      <div class="others-box">
        <div class="img3">
        <img src="/img/all-images/others/others-img1.png" alt="" />
        </div>
        <div class="text">
        <h3>Luxury Suite Villa</h3>
        <div class="space10"></div>
        <p>$1.800,000</p>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  </div>
  <!-- ===== HERO AREA ENDS ======= -->

  <!-- ===== BLOG AREA STARTS ======= -->
  <div class="blog-details-leftarea sp6">
  <div class="container">
    <div class="row">
    <div class="col-lg-5">
      <div class="blog-details-left">
      <div class="search-area">
        <h3>Search Apartment</h3>
        <div class="space28"></div>
        <form action="#">
          @csrf
        <input type="text" placeholder="Search...." />
        <button type="submit" class="header-btn4">Search Now</button>
        </form>
      </div>
      <div class="space40"></div>
      <div class="category-area">
        <h3>Blog Category</h3>
        <div class="space8"></div>
        <ul>
        <li>
          <a href="#"><span>Luxury Suite Villa</span> <span><i class="fa-solid fa-angle-right"></i></span></a>
        </li>
        <li>
          <a href="#"><span>Diamond Apartment</span> <span><i class="fa-solid fa-angle-right"></i></span></a>
        </li>
        <li>
          <a href="#"><span>Green Living Apartment</span> <span><i class="fa-solid fa-angle-right"></i></span></a>
        </li>
        <li>
          <a href="#"><span>Apartment Green Complex</span> <span><i class="fa-solid fa-angle-right"></i></span></a>
        </li>
        <li>
          <a href="#"><span>Swimming Pool Amenties</span> <span><i class="fa-solid fa-angle-right"></i></span></a>
        </li>
        </ul>
      </div>
      <div class="space40"></div>
      <div class="author-area">
        <h3>Our Author</h3>
        <div class="space28"></div>
        <ul>
        <li>
          <img src="/img/all-images/others/others-img15.png" alt="" />
        </li>
        <li>
          <img src="/img/all-images/others/others-img16.png" alt="" />
        </li>
        <li>
          <img src="/img/all-images/others/others-img17.png" alt="" />
        </li>
        <li>
          <img src="/img/all-images/others/others-img18.png" alt="" />
        </li>
        <li>
          <img src="/img/all-images/others/others-img19.png" alt="" />
        </li>
        </ul>
      </div>
      <div class="space40"></div>
      <div class="tags-area">
        <h3>Popular Tags</h3>
        <div class="space16"></div>
        <ul>
        <li>
          <a href="#">#Real Estate</a>
        </li>
        <li>
          <a href="#">#Home Sale</a>
        </li>
        <li>
          <a href="#" class="m-0">#House Hunting</a>
        </li>
        </ul>

        <ul>
        <li>
          <a href="#">#Dream Home</a>
        </li>
        <li>
          <a href="#">#Best Home</a>
        </li>
        <li>
          <a href="#" class="m-0">#Green Living</a>
        </li>
        </ul>

        <ul>
        <li>
          <a href="#">#Smart Home</a>
        </li>
        <li>
          <a href="#">#Home Listing</a>
        </li>
        <li>
          <a href="#" class="m-0">#Best Home</a>
        </li>
        </ul>
      </div>
      </div>
    </div>
    <div class="col-lg-7">
      <div class="blog-author-area pdleft">
      <div class="img1">
        <img src="/img/all-images/apartment/apartment-img26.png" alt="" />
      </div>
      <div class="space40"></div>
      <ul>
        <li>
        <a href="#"><img src="/img/all-images/others/others-img20.png" alt="" /> Ben Stokes</a> <span>|</span>
        </li>
        <li>
        <a href="#"><i class="fa-solid fa-tag"></i> Dream Home</a> <span>|</span>
        </li>
        <li>
        <a href="#"><i class="fa-solid fa-calendar-days"></i> 16 April, 2024</a> <span>|</span>
        </li>
        <li>
        <a href="#"><i class="fa-solid fa-comments"></i> 2 Comment</a>
        </li>
      </ul>
      <div class="space32"></div>
      <h2>Guest Spotlight: Memorable Moments at Luxury Suite Villa</h2>
      <div class="space20"></div>
      <p>Nestled in the heart of the city, Diamond Apartments offer a perfect blend of luxury and convenience. These elegantly designed residence boast spacious layouts, modern amenities, and stunning city views, providing a sanctuary.</p>
      <div class="space16"></div>
      <p>Each apartment features high-end finishes, including granite countertops, stainless steel appliances, hardwood floors, ensuring both style comfort.</p>
      <div class="space40"></div>
      <div class="row">
        <div class="col-lg-6 col-md-6">
        <div class="images-area">
          <div class="img1">
          <img src="/img/all-images/apartment/apartment-img27.png" alt="" />
          </div>
        </div>
        </div>
        <div class="col-lg-6 col-md-6">
        <div class="images-area">
          <div class="space30 d-md-none d-block"></div>
          <div class="img1">
          <img src="/img/all-images/apartment/apartment-img28.png" alt="" />
          </div>
        </div>
        </div>
      </div>
      <div class="space40"></div>
      <h3>Unparalleled Elegance: Discover Luxury Villa</h3>
      <div class="space20"></div>
      <p>Escape to luxury Serenity Heights, a prestigious hilltop offering panoramic views of the Pacific Ocean. This contemporary masterpiece features 5 bed rooms, 6 bathrooms, an expansive infinity pool that blends seamlessly.</p>
      <div class="space40"></div>
      <div class="apartment-contactbox">
        <h3>Send Us A Message</h3>
        <div class="space16"></div>
        <div class="row">
        <div class="col-lg-6">
          <div class="input-area">
          <input type="text" placeholder="Your Name*" />
          </div>
        </div>
        <div class="col-lg-6">
          <div class="input-area">
          <input type="number" placeholder="Mobile Number" />
          </div>
        </div>
        <div class="col-lg-12">
          <div class="input-area">
          <textarea placeholder="Your Message"></textarea>
          </div>
        </div>
        <div class="space24"></div>
        <div class="col-lg-12">
          <div class="input-area text-end">
          <button type="submit" class="header-btn4">Send Message</button>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
  </div>
  <!-- ===== BLOG AREA ENDS ======= -->

  <!-- ===== BLOG AREA STARTS ======= -->
  <div class="blog-inner-section-area sp7 bg1">
  <div class="container">
    <div class="row">
    <div class="col-lg-4 m-auto">
      <div class="heading3 text-center space-margin60">
      <h5>our blog</h5>
      <div class="space20"></div>
      <h2>Our Latest Blog</h2>
      </div>
    </div>
    </div>
    <div class="row">
    <div class="col-lg-4 col-md-6">
      <div class="blog-boxarea">
      <div class="img1 image-anime">
        <img src="/img/all-images/blog/blog-img1.png" alt="" />
      </div>
      <div class="content-area">
        <ul>
        <li>
          <a href="#"><img src="/img/icons/user.svg" alt="" /> Joe Root</a> <span>|</span>
        </li>
        <li>
          <a href="#"><img src="/img/icons/calender.svg" alt="" /> 16 April, 2024</a>
        </li>
        </ul>
        <div class="space20"></div>
        <a href="{{ url('/blogs/single') }}">How Luxury Suite Offers the Perfect Blend the Comfort</a>
        <div class="space24"></div>
        <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
      </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="blog-boxarea">
      <div class="img1 image-anime">
        <img src="/img/all-images/blog/blog-img2.png" alt="" />
      </div>
      <div class="content-area">
        <ul>
        <li>
          <a href="#"><img src="/img/icons/user.svg" alt="" /> Joe Root</a> <span>|</span>
        </li>
        <li>
          <a href="#"><img src="/img/icons/calender.svg" alt="" /> 16 April, 2024</a>
        </li>
        </ul>
        <div class="space20"></div>
        <a href="{{ url('/blogs/single') }}">Guest Spotlight: Memorable Moments at Luxury Suite Villa</a>
        <div class="space24"></div>
        <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
      </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="blog-boxarea">
      <div class="img1 image-anime">
        <img src="/img/all-images/blog/blog-img3.png" alt="" />
      </div>
      <div class="content-area">
        <ul>
        <li>
          <a href="#"><img src="/img/icons/user.svg" alt="" /> Joe Root</a> <span>|</span>
        </li>
        <li>
          <a href="#"><img src="/img/icons/calender.svg" alt="" /> 16 April, 2024</a>
        </li>
        </ul>
        <div class="space20"></div>
        <a href="{{ url('/blogs/single') }}">Behind the Scenes: The Art of Creating Luxury Suite Villa</a>
        <div class="space24"></div>
        <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
      </div>
      </div>
    </div>
    </div>
  </div>
  </div>
  <!-- ===== BLOG AREA ENDS ======= -->
@endsection