$(document).ready(function () {

$('.screenheight').height($(window).height());
$(window).scroll(function() {
  if ( $(window).scrollTop() > 100 ){
    $('body').addClass('scroll');
  } else {
    $('body').removeClass('scroll');
  }
  parallax(); 
});
parallax(); 



$('.section, section').waypoint(function(direction) {
    $(this.element).addClass('in');
    if ( $(this.element).data('function') ) {
      console.log($(this.element).data('function'));
      window[ $(this.element).data('function') ]();
    }
    this.destroy()
}, { offset: '50%'  });




$('.mobilemenu').click(function(event) {
  $('body').toggleClass('menuopen');
  event.preventDefault();
});

}); //document ready



function parallax(st) {
  if ($(window).width() > 1000) {
        if (!st) st = $(window).scrollTop();

        $('.parallax2').each(function () {
            if ( isScrolledIntoView( $(this) ) ) {

                if ($(this).attr('data-initialy')) {
                  $(this).data('initialy',$(this).attr('data-initialy'));
                } else {
                  $(this).data('initialy',$(this).offset().top);
                }

                stt = st -  $(this).data('initialy');
                var top = (1-$(this).data('speed')) * stt;
                $(this).css('transform', 'translate3d( 0, '+ top +'px, 0)');
            }
        });
  }
}

function isScrolledIntoView(ele) {
    //console.log(ele);
    var lBound = $(window).scrollTop(),
        uBound = lBound + $(window).height(),
        top = ele.offset().top,
        bottom = top + ele.outerHeight(true);

    return (top > lBound && top < uBound)
        || (bottom > lBound && bottom < uBound)
        || (lBound >= top && lBound <= bottom)
        || (uBound >= top && uBound <= bottom);
}

(function( $ ) {
 
$.fn.loopClasses = function(attr) {
  defaultattr = {'interval': 5000, 'class': 'currrent'};
  if (!attr) attr = {};
  t = this;
  $.extend(true, this, defaultattr, attr);
  
  $(':first-child',this).addClass(attr['class']);
  var action = function() {
    var next = $('.'+attr['class'], t).next();
    $('.'+attr['class'], t).removeClass(attr['class']);      
    if (next.length > 0)
      $(next).addClass(attr['class'])
    else
      $(':first-child',t).addClass(attr['class']);
  };
  setInterval(action, attr['interval']);
 
};
 
}( jQuery ));