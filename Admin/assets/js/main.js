$(window).on('load', function () {
  $('#loader').fadeOut('slow');
});

$(window).scroll(function () {
  $(".animate__paused").each(function () {
    var element = $(this);
    var elementTop = element.offset().top;
    var distance = elementTop - $(window).scrollTop();
    if (distance < 700) {
      element.css("animation-play-state", "running");
    }
  });
});

$(document).ready(function () {
  var url = window.location.href;
  if (url.includes('/login')) {
    var header = document.getElementById('header');
    header.style.display = 'none';
  }
});
