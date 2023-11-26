// document.body.addEventListener('click', function () {
//     document.getElementById('sound1').play();
// });

// $(document).ready(function () {
//     var sound2 = $("#sound2")[0];

//     $("#toggleSoundButton").hide();
//     $("#modalText").hide();

//     $("#toggleSoundButton").on("click", function () {
//         sound2.play();
//     });

//     setTimeout(function () {
//         $("#modalTitle").show();

//         setTimeout(function () {
//             $("#modalTitle").hide();
//             $("#modalText").show();

//             setTimeout(function () {
//                 $("#toggleSoundButton").show();
//             }, 3000);
//         }, 3000);
//     }, 3000);


//     function createHeart() {
//         const heart = $("<div/>").addClass("heart").appendTo("#hearts-container");
//         heart.css({
//             left: Math.random() * 100 + "vw",
//             top: Math.random() * 100 + "vh",
//             animationDuration: Math.random() * 1 + 1 + "s",
//         });
//         heart.on("animationend", function () {
//             $(this).remove();
//         });
//     }

//     function startHearts() {
//         createHeart();
//         setTimeout(function () {
//             clearInterval(heartInterval);
//         }, 30000);
//     }

//     startHearts();
//     const heartInterval = setInterval(createHeart, 450);

// });

$(document).ready(function () {


    $(".question-answer button").on("click", function () {
        var isCorrect = $(this).data("correct");

        if (isCorrect) {
            celebrate();
            showCorrectMessage();
        } else {
            showIncorrectMessage();
        }
    });

    function celebrate() {
        tsParticles.load("particles-js", {
            "fullScreen": {
                "zIndex": 1
            },
            "particles": {
                "number": {
                    "value": 50
                },
                "color": {
                    "value": [
                        "#00FFFC",
                        "#FC00FF",
                        "#fffc00"
                    ]
                },
                "shape": {
                    "type": [
                        "circle",
                        "square",
                        "triangle"
                    ],
                    "options": {}
                },
                "opacity": {
                    "value": 1,
                    "animation": {
                        "enable": true,
                        "minimumValue": 0,
                        "speed": 2,
                        "startValue": "max",
                        "destroy": "min"
                    }
                },
                "size": {
                    "value": 8,
                    "random": {
                        "enable": true,
                        "minimumValue": 4
                    }
                },
                "links": {
                    "enable": false
                },
                "life": {
                    "duration": {
                        "sync": true,
                        "value": 5
                    },
                    "count": 1
                },
                "move": {
                    "enable": true,
                    "gravity": {
                        "enable": true,
                        "acceleration": 10
                    },
                    "speed": {
                        "min": 15,
                        "max": 30
                    },
                    "decay": 0.1,
                    "direction": "none",
                    "straight": false,
                    "outModes": {
                        "default": "destroy",
                        "top": "none"
                    }
                },
                "rotate": {
                    "value": {
                        "min": 0,
                        "max": 360
                    },
                    "direction": "random",
                    "move": true,
                    "animation": {
                        "enable": true,
                        "speed": 60
                    }
                },
                "tilt": {
                    "direction": "random",
                    "enable": true,
                    "move": true,
                    "value": {
                        "min": 0,
                        "max": 360
                    },
                    "animation": {
                        "enable": true,
                        "speed": 60
                    }
                },
                "roll": {
                    "darken": {
                        "enable": true,
                        "value": 25
                    },
                    "enable": true,
                    "speed": {
                        "min": 15,
                        "max": 25
                    }
                },
                "wobble": {
                    "distance": 30,
                    "enable": true,
                    "move": true,
                    "speed": {
                        "min": -15,
                        "max": 15
                    }
                }
            },
            "emitters": {
                "life": {
                    "count": 0,
                    "duration": 0.1,
                    "delay": 0.4
                },
                "rate": {
                    "delay": 0.1,
                    "quantity": 150
                },
                "size": {
                    "width": 0,
                    "height": 0
                },
            },
        });

        $("#particles-js").show().fadeOut(6000); // Hiển thị và ẩn đi sau 3 giây
    }

    function showCorrectMessage() {
        // Hiển thị alert khi câu trả lời đúng
        showAlert("success", "Bạn đã trả lời chính xác!");
    }

    function showIncorrectMessage() {
        // Hiển thị alert khi câu trả lời sai
        showAlert("danger", "Bạn đã trả lời sai. Hãy thử lại!");
    }

    function showAlert(type, message) {
        var alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                    </div>`;

        $("body").append(alertHtml);

        setTimeout(function () {
            $(".alert").alert('close');
        }, 3000);
    }
});