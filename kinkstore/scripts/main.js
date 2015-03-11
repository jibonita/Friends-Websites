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
    $('.accordion .section').on('touchstart', function(event) {
        $('#stef').html('Touchstart: ' + $.now());
        console.log('touch start: '+$.now());
        event.preventDefault();
        event.stopPropagation();
    });

    $('.accordion .section').click(function(event) {
        event.preventDefault();
        console.log('click: '+$.now());

        var $clicked = $(this).find('.section-content');

        $('.accordion .section-content').not($clicked).slideUp(function() {
            // remove 'active' class from .section
            $(this).parent().removeClass('active');
        });

        $clicked.slideToggle(function() {
            $(this).parent().toggleClass('active');
        });

        $('#stef').html('q:' + $.now());

    });

});