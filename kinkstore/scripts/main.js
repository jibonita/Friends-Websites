$(document).ready(function(){

    $('.navbar-fluid button').click(function() {

        
            var speed = 800;
            var clicks = $(this).data('clicks');

            $('#searchfor').val(clicks);

            if (!clicks) {
                //** display menu
                //$('#menu').show(speed);
                $('#menu').css('display', 'block');
                // $('#searchfor').val('show')
            } else {

                //** hide menu
                //$('#menu').hide(speed);
                $('#menu').css('display', 'none');
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