import $ from 'jquery'

window.jQuery = window.$ = $;

// Bootstrap: only Offcanvas (the mobile nav drawer) is used anywhere on
// this site - every other component (modal, dropdown, tooltip, its own
// carousel, ...) was checked against every blade view and found unused.
// A bare side-effect import is enough: offcanvas.js self-registers a
// document-level click handler for [data-bs-toggle="offcanvas"] at load,
// same as the full bundle did.
import 'bootstrap/js/dist/offcanvas';

import '@fortawesome/fontawesome-free';
// AOS (Animate On Scroll)
import AOS from "aos";

import './plugins/mobilemenu';

import './plugins/SmoothScroll';
import 'owl.carousel/dist/owl.carousel.min.js';

import { CountUp } from 'countup.js';

import './plugins/nice-select';

// GSAP & Plugins
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

window.addEventListener('load', function() {
  document.querySelectorAll('.hero-boxarea').forEach(function(el) {
      el.classList.add('loaded');
  });
});

//========== LEAD ANALYTICS BEACON ============= //
// sendBeacon (not fetch) is required here: a WhatsApp/tel: click
// navigates or backgrounds the tab immediately, which can abort an
// in-flight fetch() - sendBeacon is guaranteed to be delivered even
// though the page is unloading right after the click.
function jbSendLead(propertyId, leadType) {
  if (!navigator.sendBeacon || !propertyId || !leadType) return;

  var payload = new Blob(
    [JSON.stringify({ property_id: propertyId, lead_type: leadType })],
    { type: 'application/json' }
  );

  navigator.sendBeacon('/api/analytics/log', payload);
}

// Delegated so it also covers WhatsApp/Call buttons rendered inside
// paginated/AJAX-free browse cards without needing per-card wiring.
document.addEventListener('click', function (event) {
  var trigger = event.target.closest('[data-lead-type]');
  if (!trigger) return;

  jbSendLead(trigger.dataset.propertyId, trigger.dataset.leadType);
});

// Single property pages stamp their id onto <body data-property-id="...">
// (see resources/views/single/index5.blade.php). type="module" scripts
// run after the document is parsed, so document.body is already
// populated here - no DOMContentLoaded wrapper needed.
if (document.body.dataset.propertyId) {
  jbSendLead(document.body.dataset.propertyId, 'profile_view');
}

;(function($){

$(document).ready(function(){


//========== HEADER ACTIVE STRATS ============= //
if ($("#header").length > 0) {
$(window).on("scroll", function (event) {
  var scroll = $(window).scrollTop();
  if (scroll < 1) {
  $(".header-area").removeClass("sticky");
  } else {
  $(".header-area").addClass("sticky");
  }
  });
}
//========== HEADER ACTIVE ENDS ============= //

//========== SIDEBAR/SEARCH AREA ============= //
$(".header-search-btn").on("click", function (e) {
  e.preventDefault();
  $(".header-search-form-wrapper").addClass("open");
  $('.header-search-form-wrapper input[type="search"]').focus();
  $('.body-overlay').addClass('active');
});
$(".tx-search-close").on("click", function (e) {
  e.preventDefault();
  $(".header-search-form-wrapper").removeClass("open");
  $("body").removeClass("active");
  $('.body-overlay').removeClass('active');
});
//========== SIDEBAR/SEARCH AREA ============= //

//========== PAGE PROGRESS STARTS ============= // 
  var progressPath = document.querySelector(".progress-wrap path");
  var pathLength = progressPath.getTotalLength();
  progressPath.style.transition = progressPath.style.WebkitTransition =
  "none";
  progressPath.style.strokeDasharray = pathLength + " " + pathLength;
  progressPath.style.strokeDashoffset = pathLength;
  progressPath.getBoundingClientRect();
  progressPath.style.transition = progressPath.style.WebkitTransition =
    "stroke-dashoffset 10ms linear";
  var updateProgress = function () {
    var scroll = $(window).scrollTop();
    var height = $(document).height() - $(window).height();
    var progress = pathLength - (scroll * pathLength) / height;
    progressPath.style.strokeDashoffset = progress;
  };
  updateProgress();
  $(window).scroll(updateProgress);
  var offset = 50;
  var duration = 550;
  jQuery(window).on("scroll", function () {
    if (jQuery(this).scrollTop() > offset) {
      jQuery(".progress-wrap").addClass("active-progress");
    } else {
      jQuery(".progress-wrap").removeClass("active-progress");
    }
  });
  jQuery(".progress-wrap").on("click", function (event) {
    event.preventDefault();
    jQuery("html, body").animate({ scrollTop: 0 }, duration);
    return false;
  });
//========== PAGE PROGRESS STARTS ============= // 

AOS.init;
AOS.init({disable: 'mobile'});

//========== NICE SELECT ============= //
// nice-select swaps the native <select> for a styled div and hides the
// original. That is fine for the template's filter bars, but the host
// property forms use native selects on purpose (label association,
// keyboard behaviour, validation focus), so opt them out.
$('select:not(.jb-native-select)').niceSelect();

//========== CASE IMAGE ============= //
$('.cs_hover_active').hover(function () {
  $(this).addClass('active').siblings().removeClass('active');
  });
});
//========== COUNTER UP============= //
const counterElements = document.querySelectorAll('.counter');

counterElements.forEach(el => {
    const endVal = parseInt(el.innerText);
    const countUp = new CountUp(el, endVal);
    if (!countUp.error) {
        countUp.start();
    } else {
        console.error(countUp.error);
    }
});
const color = $(".box-lists a.heart");
color.on("click", function () {
  $(".box-lists a.heart");
  $(this).addClass("active");
});

const color1 = $(".love a");
color1.on("click", function () {
  $(".love a");
  $(this).addClass("active");
});

//========== CAROUSELS (only sections that exist on the surviving pages) ============= //
  $('.header-carousel-area3').owlCarousel({
    loop:true,
    margin:30,
    nav:true,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    dots:false,
    items:10,
    mouseDrag:false,
    navText:["<i class='fa-solid fa-angle-up'></i>" , "<i class='fa-solid fa-angle-down'></i>"],
    autoplay:true,
    smartSpeed:3000,
    autoplayTimeout:4000,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:1,
        },
        1000:{
            items:1,
        }
    }
  });

$('.about-slider-area').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  items:10,
  mouseDrag:true,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  autoplay:true,
  smartSpeed:3000,
  autoplayTimeout:4000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:1,
      },
      1000:{
          items:1,
      }
  }
});

$('.gallery-slider-area').owlCarousel({
  loop:true,
  margin:30,
  nav:false,
  dots:false,
  items:10,
  mouseDrag:true,
  navText:["<i class='fa-solid fa-arrow-left'></i>" , "<i class='fa-solid fa-arrow-right'></i>"],
  autoplay:true,
  smartSpeed:3000,
  autoplayTimeout:4000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:2,
      },
      1000:{
          items:3,
      }
  }
});

$('.arpart-slider-area').owlCarousel({
  loop:true,
  margin:30,
  nav:true,
  dots:false,
  items:10,
  navText:["<i class='fa-solid fa-angle-left'></i>" , "<i class='fa-solid fa-angle-right'></i>"],
  autoplay:true,
  smartSpeed:3000,
  autoplayTimeout:4000,
  responsiveClass:true,
  responsive:{
      0:{
          items:1,
      },
      600:{
          items:2,
      },
      1000:{
          items:3,
      }
  }
});
//========== PRELOADER ============= //
// Removed - the .preloader overlay it tore down no longer exists. It hid the
// whole viewport behind an opaque white layer until window.load (i.e. until
// every image on the page had downloaded), which was the single biggest
// Speed Index regression on the site. See the comment in
// resources/views/layouts/partials/loader.blade.php for the full rationale.


  if($('.reveal').length){gsap.registerPlugin(ScrollTrigger);
    let revealContainers=document.querySelectorAll(".reveal");
    revealContainers.forEach((container)=>{let image=container.querySelector("img");let tl=gsap.timeline({scrollTrigger:{trigger:container,
      toggleActions:"play none none none"}});
    tl.set(container,
      {autoAlpha:1});
    tl.from(container,1.5,
      {xPercent:-100,
      ease:"power2.out"});
    tl.from(image,1.5,
      {xPercent:100,
      scale:1.3,
      delay:-1.5,
      ease:"power2.out"

    });
  });
  }
//========== GSAP BAR AREA ============= //

})(jQuery);


