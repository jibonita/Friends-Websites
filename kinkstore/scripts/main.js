$(document).ready(function() {

    var isMenuOpen = false;
    $('.navbar-fluid button.navbar-toggle').click(function() {

        var speed = 800;

        if (!isMenuOpen) {
            //** display menu
            $('#menu').slideDown(speed);
        } else {
            //** hide menu
            $('#menu').slideUp(speed / 3);
        }

        isMenuOpen = !isMenuOpen;
    });

});