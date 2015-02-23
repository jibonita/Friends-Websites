$(document).ready(function() {

    $('.navbar-fluid button.navbar-toggle').click(function() {


        var speed = 800;
        var clicks = $(this).data('clicks');

        $('#searchfor').val(new Date($.now()));

        if (!clicks) {
            //** display menu
            //$('#menu').show(speed);
            setTimeout(function() {
                $('#menu').css('display', 'block');
            }, 500);

            // $('#searchfor').val('show')
        } else {

            //** hide menu
            //$('#menu').hide(speed);
            setTimeout(function() {
                $('#menu').css('display', 'none');
            }, 500);

            // $('#searchfor').val('hide')
        }

        $(this).data('clicks', !clicks);



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