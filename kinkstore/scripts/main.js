(function() {

    $('.navbar-fluid button').click(function() {
		
        var speed = 800;
        var clicks = $(this).data('clicks');
        $(this).data('clicks', !clicks);

$('#searchfor').val(clicks);

        if (!clicks) {
            //** display menu
            $('#menu').show(speed);
           // $('#searchfor').val('show')
        } else {

            //** hide menu
            $('#menu').hide(speed );
           // $('#searchfor').val('hide')
        }
    });

})();