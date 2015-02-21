(function() {

    $('.navbar-fluid button').click(function() {
        var speed = 800;
        var clicks = $(this).data('clicks');
        $(this).data("clicks", !clicks);

        if (!clicks) {
            //** display menu
            $('#menu').show(speed);
            //alert('show');
        } else {

            //** hide menu
            $('#menu').hide(speed / 3);
            //alert('hide');
        }
    });

})();