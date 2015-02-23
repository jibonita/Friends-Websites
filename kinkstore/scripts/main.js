$(document).ready(function(){

    $('.navbar-fluid button').click(function() {

        setTimeout(function() {

            var speed = 800;
            var clicks = $(this).data('clicks');

            $('#searchfor').val(clicks);

            if (!clicks) {
                //** display menu
                $('#menu').show(speed);
                // $('#searchfor').val('show')
            } else {

                //** hide menu
                $('#menu').hide(speed);
                // $('#searchfor').val('hide')
            }

            $(this).data('clicks', !clicks);

        }, 1000);

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