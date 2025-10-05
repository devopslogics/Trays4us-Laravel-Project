
jQuery(document).ready(function(){

    $('.slick-carousel').slick({
        arrows: true,
        centerPadding: "0px",
        dots: true,
        slidesToShow: 1,
        infinite: false ,
        prevArrow: $('.custom-prev-arrow'),
        nextArrow: $('.custom-next-arrow')
      });



      $('.slick-carousel-artists').slick({
        arrows: true,
        centerPadding: "0px",
        dots: true,
        slidesToShow: 1,
        infinite: false ,
        prevArrow: $('.custom-prev-arrow-artists'),
        nextArrow: $('.custom-next-arrow-artists')
      });


      
     
 $('.slider-nav-left').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  arrows: true,

  focusOnSelect: true,
  prevArrow: $('.left-custom-prev-arrow-artists'),
  nextArrow: $('.left-custom-next-arrow-artists')
});


     
$('.slider-nav-right').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  arrows: true,
  focusOnSelect: true,
  prevArrow: $('.right-custom-prev-arrow-artists'),
  nextArrow: $('.right-custom-next-arrow-artists')
});



});