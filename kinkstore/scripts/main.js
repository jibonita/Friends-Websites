(function() {

	$('.navbar-fluid button').click(function() {
    	var speed = 800;
        var clicks = $(this).data('clicks');
        if (clicks) {
            //** hide menu
            $('#menu').hide(speed/3);
            alert('hide');
        } else {
            //** display menu
            $('#menu').show(speed);
            alert('show');
        }
        $(this).data("clicks", !clicks);
    });

})();