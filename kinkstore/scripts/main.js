$(document).ready(function() {

    var isMenuOpen = false;
    $('.navbar-fluid button.navbar-toggle').click(function() {


        var speed = 800;
        // var clicks = $(this).data('clicks');

        // $('#searchfor').val((isMenuOpen?'X:':'O:')+new Date($.now()));
        // clicks = isMenuOpen;
        
        if (!isMenuOpen) {
            //** display menu
            $('#menu').slideDown(speed);
            // setTimeout(function() {
            //     $('#menu').css('display', 'block');
            // }, 500);

            // $('#searchfor').val('show')
        } else {

            //** hide menu
            $('#menu').slideUp(speed/3);
            // setTimeout(function() {
            //     $('#menu').css('display', 'none');
            // }, 500);

            // $('#searchfor').val('hide')
        }

        //$(this).data('clicks', !clicks);
        isMenuOpen = !isMenuOpen;


        // var speed = 800;
        // var clicks = $(this).data('clicks');

        // $('#searchfor').val(clicks);

        // if (!clicks) {
        //     //** display menu
        //     $('#menu').show(speed);
        //     // $('#searchfor').val('show')
        // } else {

        //     //** hide menu
        //     $('#menu').hide(speed);
        //     // $('#searchfor').val('hide')
        // }

        // $(this).data('clicks', !clicks);
    });

});