$(document).ready(function () {
  // Youtube Overlay
  const videoOverlay = $("#Overlay");
  const Link = $("#youtubeLink");

  const popup = function (videoLink) {
    const linkUrl = videoLink.prop("href");
    videoLink.on("click", function (e) {
      e.preventDefault();
      $("#youtubeVideo").html(
        `<iframe src="${youtube.generateEmbedUrl(
          linkUrl
        )}" width="560" height="315"></iframe>`
      );
      videoOverlay.fadeIn();
    });
  };

  videoOverlay.hide();

  Link.on("click", function (e) {
    e.preventDefault();
    videoOverlay.fadeIn();
  });

  videoOverlay.on("click", function (e) {
    if (e.target === this) {
      videoOverlay.fadeOut(() => {
        $("#youtubeVideo").empty();
      });
    }
  });

  $("a#youtubeLink").each(function () {
    popup($(this));
  });

  // Change background

  const backgrounds = [
    "/assets/img/background_1.jpg",
    "/assets/img/background_2.jpg",
    "/assets/img/background_3.jpg",
  ];

  let currentIndex = 0;
  const container = $(".background");
  const location = $("#location");

  function changeBackground() {
    currentIndex = (currentIndex + 1) % backgrounds.length;
    container.css("background-image", `url("${backgrounds[currentIndex]}")`);

    location.text(
      {
        0: "Tokyo, Japan — $440.00 / night",
        1: "Shanghai, China — $290.00 / night",
        2: "HongKong — $720.00 / night",
      }[currentIndex]
    );
  }

  setInterval(changeBackground, 10000);
});


