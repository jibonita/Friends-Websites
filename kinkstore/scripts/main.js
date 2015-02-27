$(function() {

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


    //** inside page item info accordion
    $('.accordion .section').click(function(event) {
        event.preventDefault();

        var $clicked = $(this).find('.section-content');
        
        $('.accordion .section-content').not($clicked).slideUp(function() {
            // remove 'active' class from .section
            $(this).parent().removeClass('active');
        });

        $clicked.slideToggle(function() {
            $(this).parent().toggleClass('active');
        });

    });

});