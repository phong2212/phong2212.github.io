document.body.addEventListener('click', function () {
    document.getElementById('sound1').play();
});

$(document).ready(function () {
    var sound2 = $("#sound2")[0];

    $("#toggleSoundButton").hide();
    $("#modalText").hide();

    $("#toggleSoundButton").on("click", function () {
        sound2.play();
    });

    setTimeout(function () {
        $("#modalTitle").show();

        setTimeout(function () {
            $("#modalTitle").hide();
            $("#modalText").show();

            setTimeout(function () {
                $("#toggleSoundButton").show();
            }, 3000);
        }, 3000);
    }, 3000);


    function createHeart() {
        const heart = $("<div/>").addClass("heart").appendTo("#hearts-container");
        heart.css({
            left: Math.random() * 100 + "vw",
            top: Math.random() * 100 + "vh",
            animationDuration: Math.random() * 1 + 1 + "s",
        });
        heart.on("animationend", function () {
            $(this).remove();
        });
    }

    function startHearts() {
        createHeart();
        setTimeout(function () {
            clearInterval(heartInterval);
        }, 30000);
    }

    startHearts();
    const heartInterval = setInterval(createHeart, 450);

});
