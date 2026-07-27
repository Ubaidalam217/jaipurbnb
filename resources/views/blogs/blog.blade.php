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
            <h2>Our Blog</h2>
            <div class="space24"></div>
            <p>
              <a href="{{ url('/') }}">Home <i class="fa-solid fa-angle-right"></i></a> <a href="blog.html'">Our Blog</a>
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
  <div class="blog-inner-section-area sp6">
    <div class="container">
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

        <div class="col-lg-4 col-md-6">
          <div class="blog-boxarea">
            <div class="img1 image-anime">
              <img src="/img/all-images/blog/blog-img4.png" alt="" />
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
              <a href="{{ url('/blogs/single') }}">Your Urban Sanctuary Awaits in the Heart of the New City</a>
              <div class="space24"></div>
              <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="blog-boxarea">
            <div class="img1 image-anime">
              <img src="/img/all-images/blog/blog-img5.png" alt="" />
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
              <a href="{{ url('/blogs/single') }}">Discover Your Dream Home in the Heart of the City</a>
              <div class="space24"></div>
              <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="blog-boxarea">
            <div class="img1 image-anime">
              <img src="/img/all-images/blog/blog-img6.png" alt="" />
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
              <a href="{{ url('/blogs/single') }}">Find Your Perfect Home at Best Diamond Apartments</a>
              <div class="space24"></div>
              <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="blog-boxarea">
            <div class="img1 image-anime">
              <img src="/img/all-images/blog/blog-img7.png" alt="" />
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
              <a href="{{ url('/blogs/single') }}">Experience Urban Elegance at Diamond Apartments</a>
              <div class="space24"></div>
              <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="blog-boxarea">
            <div class="img1 image-anime">
              <img src="/img/all-images/blog/blog-img8.png" alt="" />
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
              <a href="{{ url('/blogs/single') }}">Where Modern Design Meets Unmatched Convenience</a>
              <div class="space24"></div>
              <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="blog-boxarea">
            <div class="img1 image-anime">
              <img src="/img/all-images/blog/blog-img9.png" alt="" />
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
              <a href="{{ url('/blogs/single') }}">Experience Urban Luxury and Unparalleled Convenience</a>
              <div class="space24"></div>
              <a href="{{ url('/blogs/single') }}" class="readmore">Read More <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="space30"></div>
          <div class="pagination-area">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Previous"><i class="fa-solid fa-angle-left"></i></a>
                </li>
                <li class="page-item">
                  <a class="page-link active" href="#">1</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">...</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#">12</a>
                </li>
                <li class="page-item">
                  <a class="page-link m-0" href="#" aria-label="Next"><i class="fa-solid fa-angle-right"></i></a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== BLOG AREA ENDS ======= -->
@endsection
