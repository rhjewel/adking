(function ($) {
  ("use strict");

  $(".sidebar-button").on("click", function () {
    $(this).toggleClass("active");
  });

  const sidebarButton = document.querySelector(".sidebar-button");

  if (sidebarButton) {
    sidebarButton.addEventListener("click", () => {
      document.querySelector(".main-menu").classList.toggle("show-menu");
    });
  }

  $(".menu-close-btn").on("click", function () {
    $(".main-menu").removeClass("show-menu");
  });

  // sidebar
  $(".right-sidebar-button").on("click", function () {
    $(".right-sidebar-menu").addClass("show-right-menu");
  });
  $(".right-sidebar-close-btn").on("click", function () {
    $(".right-sidebar-menu").removeClass("show-right-menu");
  });

  $(".menu-btn").on("click", function () {
    $(".sidebar-menu").addClass("active");
  });
  $(".sidebar-menu-close").on("click", function () {
    $(".sidebar-menu").removeClass("active");
  });

  jQuery(".dropdown-icon").on("click", function () {
    jQuery(this).toggleClass("active").next("ul, .mega-menu").slideToggle();
    jQuery(this).parent().siblings().children("ul, .mega-menu").slideUp();
    jQuery(this).parent().siblings().children(".active").removeClass("active");
  });
  jQuery(".dropdown-icon2").on("click", function () {
    jQuery(this).toggleClass("active").next(".submenu-list").slideToggle();
    jQuery(this).parent().siblings().children(".submenu-list").slideUp();
    jQuery(this).parent().siblings().children(".active").removeClass("active");
  });

  // FancyBox Js
  $('[data-fancybox="gallery-01"]').fancybox({
    buttons: ["close"],
    loop: false,
    protect: true,
  });
  $('[data-fancybox="video-player"]').fancybox({
    buttons: ["close"],
    loop: false,
    protect: true,
  });

  $(".location-card").each(function (index) {
    const uniqueGroup = "images-" + index;

    // Update each image inside .image-album-wrap with a unique data-fancybox
    $(this).find(".image-album-wrap a").attr("data-fancybox", uniqueGroup);

    // Update button click event to open only its own first image
    $(this)
      .find(".img-album-btn")
      .on("click", function () {
        startedFromIndexPage = true;
        $(this)
          .closest(".location-card")
          .find(`a[data-fancybox="${uniqueGroup}"]`)
          .first()
          .trigger("click");

        $.fancybox.getInstance().SlideShow.toggle();
      });
  });

  var startedFromIndexPage = false;

  $(document).on("click", ".StartSlideShowFirstImage", function () {
    startedFromIndexPage = true;
    $('a[data-fancybox="images"]').first().trigger("click");
    $.fancybox.getInstance().SlideShow.toggle();
  });

  $('[data-fancybox="images"]').fancybox({
    fullScreen: {
      autoStart: true,
    },
    buttons: ["slideShow", "share", "close"],
    onSlideShowChange: function (instance, current, active) {
      console.info("SlideShow active? " + active);
      if (active && !startedFromIndexPage) {
        instance.next();
      }
      startedFromIndexPage = false;
    },
  });


  //Counter up
  $(".counter").counterUp({
    delay: 10,
    time: 1000,
  });

  // Home1 Banner Slider

  // Home1 Service Slider
  var swiper = new Swiper(".newest-slider", {
    slidesPerView: 1,
    speed: 1500,
    spaceBetween: 24,
    autoplay: {
      delay: 2500, // Autoplay duration in milliseconds
      pauseOnMouseEnter: true,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".newest-slider-next",
      prevEl: ".newest-slider-prev",
    },
    breakpoints: {
      280: {
        slidesPerView: 1,
      },
      386: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      576: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 15,
      },
      992: {
        slidesPerView: 3,
      },
      1200: {
        slidesPerView: 3,
      },
      1400: {
        slidesPerView: 3,
      },
    },
  });
  var swiper = new Swiper(".testimonial-slider", {
    slidesPerView: 1,
    speed: 1500,
    spaceBetween: 24,
    autoplay: {
      delay: 2500, // Autoplay duration in milliseconds
      pauseOnMouseEnter: true,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".testimonial-slider-next",
      prevEl: ".testimonial-slider-prev",
    },
    breakpoints: {
      280: {
        slidesPerView: 1,
      },
      386: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      576: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 15,
      },
      992: {
        slidesPerView: 2,
      },
      1200: {
        slidesPerView: 3,
      },
      1400: {
        slidesPerView: 3,
      },
    },
  });


  // Recent Product Slider
  var swiper = new Swiper(".related-product-slider", {
    speed: 1500,
    spaceBetween: 24,
    autoplay: {
      delay: 2000, // Autoplay duration in milliseconds
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    navigation: {
      nextEl: ".related-product-slider-next",
      prevEl: ".related-product-slider-prev",
    },

    breakpoints: {
      280: {
        slidesPerView: 1,
      },
      420: {
        slidesPerView: 1,
        spaceBetween: 15,
      },
      576: {
        slidesPerView: 2,
        spaceBetween: 15,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      },
      1200: {
        slidesPerView: 4,
      },
      1400: {
        slidesPerView: 4,
      },
    },
  });
  // Brand Logo
  var swiper = new Swiper(".brand-slider", {
    slidesPerView: 1,
    speed: 1500,
    spaceBetween: 24,
    autoplay: {
      delay: 2500, // Autoplay duration in milliseconds
      pauseOnMouseEnter: true,
      disableOnInteraction: false,
    },
    breakpoints: {
      280: {
        slidesPerView: 2,
        spaceBetween: 15,
      },
      386: {
        slidesPerView: 2,
        spaceBetween: 10,
      },
      576: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      992: {
        slidesPerView: 4,
      },
      1200: {
        slidesPerView: 6,
      },
      1400: {
        slidesPerView: 7,
      },
    },
  });
  // Galler Img Slider
  if (document.querySelector(".gallery-img-slider")) {
    new Swiper(".gallery-img-slider", {
      slidesPerView: 1,
      speed: 1200,
      spaceBetween: 0,
      loop: true,
      effect: "fade",
      fadeEffect: {
        crossFade: true,
      },
      autoplay: {
        delay: 1800,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      navigation: {
        nextEl: ".img-gallery-next",
        prevEl: ".img-gallery-prev",
      },
    });
  }
  // Home2 Banner Slider
  var bannerContentSwiper = new Swiper(".home2-banner-content-slider", {
    loop: false,
    speed: 1200,
    slidesPerView: 1,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    breakpoints: {
      280: {
        slidesPerView: 1
      },
      386: {
        slidesPerView: 1
      },
      576: {
        slidesPerView: 2,
        spaceBetween: 15
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 15
      },
      992: {
        slidesPerView: 4,
        spaceBetween: 15
      },
      1200: {
        slidesPerView: 4
      },
      1400: {
        slidesPerView: 4
      },
    },
  });
  var swiper = new Swiper(".home2-banner-slider", {
    loop: false,
    speed: 1200,
    effect: "fade",
    slidesPerView: 1,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    thumbs: {
      swiper: bannerContentSwiper,
    },

    on: {
      init: function () {
        updateProgress(this.activeIndex);
      },
      slideChangeTransitionStart: function () {
        updateProgress(this.activeIndex);
      }
    },
  });

  function updateProgress(index) {
    // remove all animate class
    document.querySelectorAll(".slide_progress-bar").forEach(function (el) {
      el.classList.remove("animate");
    });

    // add animate class to active one
    var activeProgress = document.querySelectorAll(".slide_progress-bar")[index];
    if (activeProgress) {
      // restart animation trick
      activeProgress.classList.remove("animate");
      void activeProgress.offsetWidth;
      activeProgress.classList.add("animate");
    }
  }
  //wow js
  jQuery(window).on("load", function () {
    new WOW().init();
    window.wow = new WOW({
      boxClass: "wow",
      animateClass: "animated",
      offset: 0,
      mobile: true,
      live: true,
      offset: 80,
    });
    window.wow.init();
  });

  // niceSelect
  if ($("select").length) {
    $('select:not(table.variations select,.comment-form-rating #rating,.country_select,.state_select,.country_to_state)').niceSelect();
  }

  // Language Btn
  $(document).on("click", ".header-cart-btn, .search-btn", function (e) {

    let parent = $(this).parent();

    parent.find(".cart-menu, .search-input").toggleClass("active");

    e.stopPropagation();
    // $(".cart-menu, .search-input").toggleClass("active");

  });

  $(document).on("click", function (e) {
    if (!$(e.target).closest(".cart-menu, .header-cart-btn, .search-input, .search-btn").length) {
      $(".cart-menu, .search-input").removeClass("active");
    }
  });

  // Contact DropDown Btn
  $(".contact-dropdown-btn").on("click", function (e) {
    let parent = $(this).parent();
    parent.find(".contact-list").toggleClass("active");
    e.stopPropagation();
  });
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".contact-dropdown-btn").length) {
      $(".contact-list").removeClass("active");
    }
  });

  //Quantity Increment Guest
  function updateGuestSummary() {
    let totalAdults = 0;
    let totalChildren = 0;

    $('input[name="adult_quantity"]').each(function () {
      totalAdults += parseInt($(this).val(), 10) || 0;
    });

    $('input[name="child_quantity"]').each(function () {
      totalChildren += parseInt($(this).val(), 10) || 0;
    });

    $("#adult-qty").text(totalAdults);
    $("#child-qty").text(totalChildren);
  }

  function updateRoomTitles() {
    $(".room-list .single-room").each(function (index) {
      $(this)
        .find(".room-title h6")
        .text(`Room-${index + 1}`);
    });
  }

  function updateRoomSummary() {
    const roomCount = $(".room-list .single-room").length;
    $(".custom-select-dropdown span strong").text(roomCount);

    if (roomCount <= 1) {
      $(".room-delete-btn").hide();
    } else {
      $(".room-delete-btn").show();
    }
  }

  function createNewRoom() {
    const $lastRoom = $(".room-list .single-room").last();
    const $newRoom = $lastRoom.clone();

    // Reset values
    $newRoom.find('input[name="adult_quantity"]').val(1);
    $newRoom.find('input[name="child_quantity"]').val(0);
    $newRoom.find(".guest-count").hide();
    $newRoom.removeClass("active-room");

    return $newRoom;
  }

  // Event delegation for plus/minus buttons
  $(document).on(
    "click",
    ".guest-quantity__plus, .guest-quantity__minus",
    function (e) {
      e.preventDefault();

      const $btn = $(this);
      const $input = $btn.siblings(".quantity__input");
      const type = $btn.data("type");
      let value = parseInt($input.val(), 10) || 0;

      if ($btn.hasClass("guest-quantity__minus")) {
        if (
          (type === "adult" && value > 1) ||
          (type === "child" && value > 0)
        ) {
          $input.val(value - 1);
        }
      } else {
        $input.val(value + 1);
      }

      updateGuestSummary();
    },
  );

  // Accordion toggle
  $(document).on("click", ".room-title", function () {
    const $thisRoom = $(this).closest(".single-room");

    if ($thisRoom.hasClass("active-room")) return;

    $(".single-room")
      .not($thisRoom)
      .removeClass("active-room")
      .find(".guest-count")
      .slideUp(200);
    $thisRoom.addClass("active-room").find(".guest-count").slideDown(200);
  });

  // Initial setup
  $(document).ready(function () {
    $(".room-list .single-room").first().find(".guest-count").show();
    $(".room-list .single-room").first().addClass("active-room");
    updateRoomSummary();
  });

  $(document).ready(function () {
    $(".filter-item-list .single-item").on("click", function () {
      var $clickedItem = $(this);
      var index = $clickedItem.index();

      // Add 'active' class to clicked item and remove from others
      $clickedItem.addClass("active").siblings().removeClass("active");

      // Show corresponding .filter-input by index
      $(".filter-input-wrap .filter-input")
        .removeClass("show")
        .eq(index)
        .addClass("show");
    });
  });

  //Package details Accordion expand and collapse
  document.querySelectorAll(".tour-itinerary-area").forEach(function (area) {
    const expandBtn = area.querySelector(".expand-btn");
    if (expandBtn) {
      expandBtn.addEventListener("click", function (e) {
        e.preventDefault();
        const isExpanded = expandBtn.classList.contains("expanded");

        $(
          "#accordionTourPlan .accordion-collapse, #accordionTourPlan2 .accordion-collapse",
        ).each(function () {
          if (isExpanded) {
            $(this).collapse("hide");
          } else {
            $(this).collapse("show");
          }
        });

        expandBtn.textContent = isExpanded ? "Expand All +" : "Collapse All -";
        expandBtn.classList.toggle("expanded");
      });
    }
  });

  //Progress Bar
  document.querySelectorAll(".rating-progress-bar-wrap").forEach((wrap) => {
    const bar = wrap.querySelector(".rating-progress-bar-per");
    const percentDisplay = wrap.querySelector(".data-per");
    const target = parseFloat(bar.getAttribute("data-per")); // e.g., 90
    const duration = 1000; // in milliseconds

    let startTime = null;

    function animate(timestamp) {
      if (!startTime) startTime = timestamp;
      const elapsed = timestamp - startTime;
      const progress = Math.min(elapsed / duration, 1); // Ensure it doesn't go over 1

      const current = Math.floor(target * progress);
      bar.style.width = current + "%";
      percentDisplay.textContent = current + "%";

      if (progress < 1) {
        requestAnimationFrame(animate);
      }
    }

    requestAnimationFrame(animate);
  });

  // star-rating
  $(".rating-container .star-icon").each(function () {
    let self = $(this);

    self.on("mouseenter", function () {
      $(this).prevAll().addBack().addClass("hovered");
    });

    self.on("mouseleave", function () {
      $(".star-icon").removeClass("hovered");
    });

    self.on("click", function () {
      const rating = $(this).prevAll().length + 1;
      const parent = $(this).parent();
      parent.attr("data-rating", rating);

      parent.find(".star-icon").removeClass("selected");
      parent.find(".star-icon").each(function (index) {
        if (index < rating) {
          $(this).addClass("selected");
        }
      });
    });

    // On load or if data-rating already exists
    const parent = self.parent();
    const initRating = parseInt(parent.attr("data-rating")) || 0;
    parent.find(".star-icon").each(function (index) {
      if (index < initRating) {
        $(this).addClass("selected");
      }
    });
  });


  // Handle parent to child checkbox behavior
  jQuery('.sidebar-category-dropdown .containerss input[type="checkbox"]').on(
    "change",
    function () {
      const isChecked = $(this).prop("checked");
      const $container = $(this).closest(".containerss");
      const $checkboxes = $container
        .next("ul")
        .find('li input[type="checkbox"]');
      $checkboxes.prop("checked", isChecked);
    },
  );

  // Handle child to parent checkbox behavior
  jQuery('.sub-category li input[type="checkbox"]').on("change", function () {
    const $subCategory = $(this).closest("ul.sub-category");
    const $parentCheckbox = $subCategory
      .prevAll("label.containerss")
      .find('input[type="checkbox"]');

    if ($(this).prop("checked")) {
      $parentCheckbox.prop("checked", true);
    } else {
      // If no other siblings are checked, uncheck the parent
      const anyChecked =
        $subCategory.find('input[type="checkbox"]:checked').length > 0;
      $parentCheckbox.prop("checked", anyChecked);
    }
  });


  //Cart Menu Quantity button toggle
  $(".qty-btn").on("click", function (e) {
    e.stopPropagation();
    // Toggle "active" class for the current quantity button and its related elements
    $(this).next(".quantity-area").toggleClass("active");

    // Remove "active" class from other quantity buttons and related elements
    $(".quantity-area")
      .not($(this).next(".quantity-area"))
      .removeClass("active");
  });
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".quantity-area").length) {
      // Remove "active" class from all quantity buttons and related elements
      $(".quantity-area").removeClass("active");
    }
  });

  //Quantity Increment
  $(".quantity__minus").on("click", function (e) {
    e.preventDefault();
    var input = $(this).siblings(".quantity__input");
    var value = parseInt(input.val(), 10);
    if (value > 1) {
      value--;
    }
    input.val(value.toString().padStart(2, "0"));
  });
  $(".quantity__plus").on("click", function (e) {
    e.preventDefault();
    var input = $(this).siblings(".quantity__input");
    var value = parseInt(input.val(), 10);
    value++;
    input.val(value.toString().padStart(2, "0"));
  });

  // Payment Method
  $(function () {
    $(".choose-payment-method ul li").on("click", function () {
      $(".choose-payment-method ul li").removeClass("active"); // Remove active class from all list items
      if ($(this).hasClass("stripe")) {
        $("#StripePayment").show();
        $("#OfflinePayment").hide();
        $(this).addClass("active"); // Add active class to the clicked list item
      } else if ($(this).hasClass("paypal")) {
        $("#OfflinePayment").hide();
        $("#StripePayment").hide();
        $(this).addClass("active"); // Add active class to the clicked list item
      } else if ($(this).hasClass("offline")) {
        $("#OfflinePayment").show();
        $("#StripePayment").hide();
        $(this).addClass("active"); // Add active class to the clicked list item
      } else {
        $("#StripePayment").hide();
        $("#OfflinePayment").hide();
      }
    });
  });

  function adkingProductGalleryVideo() {
    $(".woocommerce-product-gallery").each(function () {
      var $gallery = $(this);

      if ($gallery.data("adkingProductVideoReady")) {
        return;
      }

      var $videoSlide = $gallery.find(".adking-product-video-slide").first();

      if (!$videoSlide.length) {
        return;
      }

      $gallery.data("adkingProductVideoReady", true);

      var $video = $videoSlide.find("video").first();
      var videoIndex = $gallery.find(".woocommerce-product-gallery__wrapper > .woocommerce-product-gallery__image").index($videoSlide);

      function pauseVideo() {
        if ($video.length) {
          $video.get(0).pause();
        }
      }

      function playVideo() {
        if ($video.length) {
          var promise = $video.get(0).play();

          if (promise && typeof promise.catch === "function") {
            promise.catch(function () {});
          }
        }
      }

      function syncVideoState() {
        var isActive = $videoSlide.hasClass("flex-active-slide");

        if (isActive) {
          playVideo();
        } else {
          pauseVideo();
        }
      }

      $gallery.find(".flex-control-thumbs li").eq(videoIndex).addClass("adking-product-video-thumb");

      $gallery.on("mouseenter focusin", ".flex-control-thumbs li", function () {
        $(this).find("img").trigger("click");
      });

      $gallery.on("mouseenter focusin", ".adking-product-video-thumb", playVideo);
      $gallery.on("mouseleave", pauseVideo);

      $gallery.on("click mouseenter focusin", ".flex-control-thumbs li", function () {
        window.setTimeout(syncVideoState, 80);
      });

      $gallery.on("woocommerce_gallery_init_zoom flexslider:after", syncVideoState);
      window.setTimeout(syncVideoState, 400);
    });
  }

  $(window).on("load", adkingProductGalleryVideo);
  $(document.body).on("wc_fragments_refreshed updated_wc_div", adkingProductGalleryVideo);


  // Back To Top
  $(document).ready(function () {
    "use strict";
    var progressPath = document.querySelector(
      ".progress-wrap .progress-circle path",
    );
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
    jQuery(".progress-wrap").on("click", function () {
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    });
  });

})(jQuery);