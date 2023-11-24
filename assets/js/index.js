$(document).ready(function () {
    // Function to create a heart animation
    function createHeart() {
        const heart = $("<div/>").addClass("heart").appendTo("#hearts-container");
        heart.css({
            left: Math.random() * 100 + "vw",
            top: Math.random() * 100 + "vh",
            animationDuration: Math.random() * 1 + 1 + "s", // Adjust the speed range as needed
        });

        // Remove the heart from the DOM after the animation
        heart.on("animationend", function () {
            $(this).remove();
        });
    }

    // Function to start the heart animations
    function startHearts() {
        // Interval for continuously creating hearts
        setInterval(createHeart, 450); // Adjust the interval for more hearts
    }

    // Event handler for the button click
    $("#love").on("click", function () {
        // Start the heart animations
        startHearts();
    });
});
