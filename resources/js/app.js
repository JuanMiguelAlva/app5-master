$.js = function(el) {
  return $('[data-js=' + el + ']')
};

function carousel() {
  $.js('timeline-carousel').slick({
    infinite: false,
    arrows: true,
    arrows: true,
    prevArrow: '<div class="slick-prev"> <div class="btn d-flex justify-content-center align-items-center"> <div style="padding-left: 3px;"><i class="bx bx-chevron-left"></i></div></div></div>',
    nextArrow: '<div class="slick-next"> <div class="btn d-flex justify-content-center align-items-center"> <div><i class="bx bx-chevron-right"></i></div></div></div>',
    // prevArrow: false,
    // nextArrow: false,
    dots: true,
    autoplay: false,
    speed: 500,
    slidesToShow: 4,
    slidesToScroll: 4,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          dots: false,
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      },
      {
        breakpoint: 992,
        settings: {
          // dots: false,
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3
        }
      }
    ]
  });
}
carousel();

function getPageList(totalPages, page, maxLength){
  function range(start,end){
    return Array.from(Array(end-start+1),(_,i)=> i +start);
  }

  var sideWitdh = maxLength < 9 ? 1 : 2;
  var leftWidth = (maxLength -sideWitdh*2-3) >> 1;
  var rightWidth = (maxLength -sideWitdh*2-3) >> 1;
  
  if(totalPages <= maxLength){
    return range (1,totalPages);
  }

  if(page <= maxLength - sideWitdh - 1 - rightWidth){
    return range(1,maxLength-sideWitdh-1).concat(0,range(totalPages-sideWitdh+1, totalPages));
  }

  if(page >= totalPages - sideWitdh - 1 - rightWidth){
    return range(1,sideWitdh).concat(0,range(totalPages-sideWitdh-1, - rightWidth - leftWidth, totalPages));
  }

    return range(1, sideWitdh).concat(0, range(page - leftWidth, page + rightWidth),0, range(totalPages - sideWitdh + 1, totalPages));
}


// Horarios

const selectCiclo = document.getElementById('select-ciclo');

window.addEventListener('DOMContentLoaded', () => {
  selectCiclo.dispatchEvent(new Event('change'));
});

selectCiclo.addEventListener('change', () => {
    const cicloSeleccionado = selectCiclo.value;

    const contenedores = document.querySelectorAll('.cont');

    contenedores.forEach(contenedor => {
      contenedor.style.display = 'none';
    });

    const contenedorSeleccionado = document.querySelector(`.cont[data-ciclo="${cicloSeleccionado}"]`);
    if (contenedorSeleccionado) {
        contenedorSeleccionado.style.display = 'block';
    }
    
    contenedores.forEach(contenedor => {
        if (contenedor.dataset.ciclo != cicloSeleccionado) {
            contenedor.style.display = 'none';
        }
    });
});

//validate

!(function($) {
  "use strict";
  
    // Preloader
    $(window).on('load', function() {
      if ($('#preloader').length) {
        $('#preloader').delay(50).fadeOut('slow', function() {
          $(this).remove();
        });
      }
    });

  $('form.php-email-form').submit(function(e) {
    e.preventDefault();
    
    var f = $(this).find('.form-group'),
      ferror = false,
      emailExp = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i;

    f.children('input').each(function() { // run all inputs
    
      var i = $(this); // current input
      var rule = i.attr('data-rule');

      if (rule !== undefined) {
        var ierror = false; // error flag for current input
        var pos = rule.indexOf(':', 0);
        if (pos >= 0) {
          var exp = rule.substr(pos + 1, rule.length);
          rule = rule.substr(0, pos);
        } else {
          rule = rule.substr(pos + 1, rule.length);
        }

        switch (rule) {
          case 'required':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break;

          case 'minlen':
            if (i.val().length < parseInt(exp)) {
              ferror = ierror = true;
            }
            break;

          case 'email':
            if (!emailExp.test(i.val())) {
              ferror = ierror = true;
            }
            break;

          case 'checked':
            if (! i.is(':checked')) {
              ferror = ierror = true;
            }
            break;

          case 'regexp':
            exp = new RegExp(exp);
            if (!exp.test(i.val())) {
              ferror = ierror = true;
            }
            break;
        }
        i.next('.validate').html((ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
      }
    });
    f.children('textarea').each(function() { // run all inputs

      var i = $(this); // current input
      var rule = i.attr('data-rule');

      if (rule !== undefined) {
        var ierror = false; // error flag for current input
        var pos = rule.indexOf(':', 0);
        if (pos >= 0) {
          var exp = rule.substr(pos + 1, rule.length);
          rule = rule.substr(0, pos);
        } else {
          rule = rule.substr(pos + 1, rule.length);
        }

        switch (rule) {
          case 'required':
            if (i.val() === '') {
              ferror = ierror = true;
            }
            break;

          case 'minlen':
            if (i.val().length < parseInt(exp)) {
              ferror = ierror = true;
            }
            break;
        }
        i.next('.validate').html((ierror ? (i.attr('data-msg') != undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
      }
    });
    if (ferror) return false;

    var this_form = $(this);
    var action = $(this).attr('action');

    if( ! action ) {
      this_form.find('.loading').slideUp();
      this_form.find('.error-message').slideDown().html('The form action property is not set!');
      return false;
    }
    
    this_form.find('.sent-message').slideUp();
    this_form.find('.error-message').slideUp();
    this_form.find('.loading').slideDown();

    if ( $(this).data('recaptcha-site-key') ) {
      var recaptcha_site_key = $(this).data('recaptcha-site-key');
      grecaptcha.ready(function() {
        grecaptcha.execute(recaptcha_site_key, {action: 'php_email_form_submit'}).then(function(token) {
          php_email_form_submit(this_form,action,this_form.serialize() + '&recaptcha-response=' + token);
        });
      });
    } else {
      php_email_form_submit(this_form,action,this_form.serialize());
    }
    
    return true;
  });

  function php_email_form_submit(this_form, action, data) {
    $.ajax({
      type: "POST",
      url: action,
      data: data,
      timeout: 40000
    }).done( function(msg){
      // if (msg.trim() == 'OK') {
        this_form.find('.loading').slideUp();
        this_form.find('.sent-message').slideDown();
        this_form.find("input:not(input[type=submit]), textarea").val('');
      // } else {
      //   this_form.find('.loading').slideUp();
      //   this_form.find('.sent-message').slideDown();
      //   if(!msg) {
      //     msg = 'Form submission failed and no error message returned from: ' + action + '<br>';
      //   }
      //   this_form.find('.error-message').slideDown().html(msg);
      // }
    }).fail( function(data){
      console.log(data);
      var error_msg = "Form submission failed!<br>";
      if(data.statusText || data.status) {
        error_msg += 'Status:';
        if(data.statusText) {
          error_msg += ' ' + data.statusText;
        }
        if(data.status) {
          error_msg += ' ' + data.status;
        }
        error_msg += '<br>';
      }
      if(data.responseText) {
        error_msg += data.responseText;
      }
      this_form.find('.loading').slideUp();
      this_form.find('.error-message').slideDown().html(error_msg);
    });
  }

})(jQuery);


$(function(){
  var numberOfItems = $(".contenido .c").length;
  var limitPerPAge = 8;
  var totalPages = Math.ceil(numberOfItems/limitPerPAge);
  var paginationSize = 5;
  var currentPage;

  function showPage(whichPage){
    if(whichPage<1||whichPage>totalPages) return false;

    currentPage = whichPage;

    $(".contenido .c").hide().slice((currentPage-1)*limitPerPAge,currentPage*limitPerPAge).show();

    $(".pagination li").slice(1,-1).remove();
    
    getPageList(totalPages, currentPage, paginationSize).forEach(item=>{
      $("<li>").addClass("page-item").addClass(item ? "current-page" : "dots")
      .toggleClass("active",item===currentPage).append($("<a>").addClass("page-link")
      .attr({href:"javascript:void(0)"}).text(item||"...")).insertBefore(".next-page");
    });

    $(".prev-page").toggleClass("disabled", currentPage===1);
    $(".next-page").toggleClass("disabled", currentPage===totalPages);

    return true;
  }

  $(".pagination").append(
    $("<li>").addClass("page-item").addClass("prev-page").append($("<a>").addClass("page-link scrollto").attr({href:"#plana"}).text("Anterior")),
    $("<li>").addClass("page-item").addClass("next-page").append($("<a>").addClass("page-link scrollto").attr({href:"#plana"}).append($("<span>&raquo;</span>")))

  );

  $(".contenido").show();
  showPage(1);

  $(document).on("click",".pagination li.current-page:not(.active)",function(){
    return showPage(+$(this).text());
  });

  $(".next-page").on("click",function(){
    return showPage(currentPage + 1);
  });

  $(".prev-page").on("click",function(){
    return showPage(currentPage - 1);
  });
});


!(function($) {
    "use strict";
  
    // Smooth scroll for the navigation menu and links with .scrollto classes
    var scrolltoOffset = $('#header').outerHeight() - 21;
    if (window.matchMedia("(max-width: 991px)").matches) {
      scrolltoOffset -= 20;
    }
    $(document).on('click', '.nav-menu a, .mobile-nav a, .scrollto', function(e) {
      if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = $(this.hash);
        if (target.length) {
          e.preventDefault();
  
          var scrollto = target.offset().top - scrolltoOffset;
  
          if ($(this).attr("href") == '#header') {
            scrollto = 0;
          }
  
          $('html, body').animate({
            scrollTop: scrollto
          },  10, 'swing');
  
          if ($(this).parents('.nav-menu, .mobile-nav').length) {
            $('.nav-menu .active, .mobile-nav .active').removeClass('active');
            $(this).closest('li').addClass('active');
          }
  
          if ($('body').hasClass('mobile-nav-active')) {
            $('body').removeClass('mobile-nav-active');
            $('.mobile-nav-toggle i').toggleClass('icofont-navigation-menu icofont-close');
            $('.mobile-nav-overly').fadeOut();
          }
          return false;
        }
      }
    });
  
    // Activate smooth scroll on page load with hash links in the url
    $(document).ready(function() {
      if (window.location.hash) {
        var initial_nav = window.location.hash;
        if ($(initial_nav).length) {
          var scrollto = $(initial_nav).offset().top - scrolltoOffset;
          $('html, body').animate({
            scrollTop: scrollto
          }, 10, 'swing');
        }
      }
    });
  
    // Navigation active state on scroll
    var nav_sections = $('section');
    var main_nav = $('.nav-menu, .mobile-nav');
  
    $(window).on('scroll', function() {
      var cur_pos = $(this).scrollTop() + 200;
  
      nav_sections.each(function() {
        var top = $(this).offset().top,
          bottom = top + $(this).outerHeight();
  
        if (cur_pos >= top && cur_pos <= bottom) {
          if (cur_pos <= bottom) {
            main_nav.find('li').removeClass('active');
          }
          main_nav.find('a[href="#' + $(this).attr('id') + '"]').parent('li').addClass('active');
        }
        if (cur_pos < 300) {
          $(".nav-menu ul:first li:first, .mobile-menu ul:first li:first").addClass('active');
        }
      });
    });
  
    // Mobile Navigation
    if ($('.nav-menu').length) {
      var $mobile_nav = $('.nav-menu').clone().prop({
        class: 'mobile-nav d-lg-none'
      });
      $('body').append($mobile_nav);
      $('body').prepend('<button type="button" class="mobile-nav-toggle d-lg-none"><i class="bi bi-list"></i></button>');
      $('body').append('<div class="mobile-nav-overly"></div>');
  
      $(document).on('click', '.mobile-nav-toggle', function(e) {
        $('body').toggleClass('mobile-nav-active');
        $('.mobile-nav-toggle i').toggleClass('bi bi-list bi-x');
        $('.mobile-nav-overly').toggle();
      });
  
      $(document).on('click', '.mobile-nav .drop-down > a', function(e) {
        e.preventDefault();
        $(this).next().slideToggle(300);
        $(this).parent().toggleClass('active');
      });
  
      $(document).click(function(e) {
        var container = $(".mobile-nav, .mobile-nav-toggle");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
          if ($('body').hasClass('mobile-nav-active')) {
            $('body').removeClass('mobile-nav-active');
            $('.mobile-nav-toggle i').toggleClass('bi bi-list bi-x');
            $('.mobile-nav-overly').fadeOut();
          }
        }
      });
    } else if ($(".mobile-nav, .mobile-nav-toggle").length) {
      $(".mobile-nav, .mobile-nav-toggle").hide();
    }
  
    // Toggle .header-scrolled class to #header when page is scrolled
    $(window).scroll(function() {
      if ($(this).scrollTop() > 100) {
        $('#header').addClass('header-scrolled');
        $('#topbar').addClass('topbar-scrolled');
      } else {
        $('#header').removeClass('header-scrolled');
        $('#topbar').removeClass('topbar-scrolled');
      }
    });
  
    if ($(window).scrollTop() > 100) {
      $('#header').addClass('header-scrolled');
      $('#topbar').addClass('topbar-scrolled');
    }
  
    // Back to top button
    $(window).scroll(function() {
      if ($(this).scrollTop() > 100) {
        $('.back-to-top').fadeIn('slow');
      } else {
        $('.back-to-top').fadeOut('slow');
      }
    });
  
    $('.back-to-top').click(function() {
      $('html, body').animate({
        scrollTop: 0
      }, 10, 'swing');
      return false;
    });
  
    // Skills section
    // $('.skills-content').waypoint(function() {
    //   $('.progress .progress-bar').each(function() {
    //     $(this).css("width", $(this).attr("aria-valuenow") + '%');
    //   });
    // }, {
    //   offset: '80%'
    // });
  
    // jQuery counterUp
    // $('[data-toggle="counter-up"]').counterUp({
    //   delay: 10,
    //   time: 1000
    // });
  
    // Testimonials carousel (uses the Owl Carousel library)
    // $(".testimonials-carousel").owlCarousel({
    //   autoplay: true,
    //   dots: true,
    //   loop: true,
    //   items: 1
    // });
  
    // Porfolio isotope and filter
    // $(window).on('load', function() {
    //   var portfolioIsotope = $('.portfolio-container').isotope({
    //     itemSelector: '.portfolio-item'
    //   });
  
    //   $('#portfolio-flters li').on('click', function() {
    //     $("#portfolio-flters li").removeClass('filter-active');
    //     $(this).addClass('filter-active');
  
    //     portfolioIsotope.isotope({
    //       filter: $(this).data('filter')
    //     });
    //     aos_init();
    //   });
  
    //   $(document).ready(function() {
    //     $('.venobox').venobox();
    //   });
    // });
  
    
  
  
  
  
  
  
    
  
    //Ciclos
    // $(window).on('load', function() {
    //   var portfolioIsotope = $('.curso-container').isotope({
    //     itemSelector: '.curso',
    //     resizable: false,
    //     layoutMode: 'fitRows'
    //     // layoutMode: 'packery'
    //   });
  
    //   portfolioIsotope.isotope({
    //     filter: ".filter-1"
    //   });
  
    //   $('#ciclos li').on('click', function() {
  
    //     $("#ciclos li").removeClass('filter-active');
    //     $(this).addClass('filter-active');
  
    //     portfolioIsotope.isotope({
    //       filter: $(this).data('filter'),
    //     });
  
    //     aos_init();
    //   });
  
    // });
  
  
  
  
  
  
  
  
  
  
    // Portfolio details carousel
    // $(".portfolio-details-carousel").owlCarousel({
    //   autoplay: true,
    //   dots: true,
    //   loop: true,
    //   items: 1
    // });
  
    // Init AOS
    // function aos_init() {
    //   AOS.init({
    //     duration: 1000,
    //     once: true
    //   });
    // }
    // $(window).on('load', function() {
    //   aos_init();
    // });
  })(jQuery);


  