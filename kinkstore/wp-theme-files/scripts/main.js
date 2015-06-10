$(function() {

    //** fluid top-menu for smaller screens
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

    //** left sidebar sub-categories: check if category has sub-categories
    $categories = $('#sidebar>ul>li');
    $categories.each(function() {
        if (!($(this).find('ul').length)) {
            $(this).find('>a').addClass('non-expand-item');
        }
    });


    //** left sidebar sub-categories open/close
    $('#sidebar>ul>li>a').click(function(e) {
        //$(this).parent().find('ul').toggleClass('displayMe');

        //if sub-ul does not exist, remove the expand symbol and do not apply this function to it
        if ($(this).parent().find('ul').length) {
            $(this).parent().find('ul').slideToggle({
                'start': function() {
                    $(this).parent().find('>a').toggleClass('non-expand-item');
                }
            });
            e.preventDefault();

        }
    });


    //** inside page item info accordion
    $('.accordion .section').on('touchstart', function(event) {
        //$('#stef').html('Touchstart: ' + $.now());
        //console.log('touch start: '+$.now());
        //event.preventDefault();
        event.stopPropagation();

        //$('#stef').html('Touchstart-ENDs: ' + $.now());
    });

    $('.accordion .section').click(function(event) {
        event.preventDefault();
        //event.stopPropagation();
        //console.log('click: '+$.now()+ this.innerHTML);

        var $clicked = $(this).find('.section-content');

        $('.accordion .section-content').not($clicked).slideUp(function() {
            // remove 'active' class from .section
            $(this).parent().removeClass('active');
        });

        $clicked.slideToggle(function() {
            $(this).parent().toggleClass('active');
        });

        //$('#stef').html('click:' + $.now());

    });

});

jQuery(document).ready(function($) {
    var defaultVisibleElements = 4;
    if ($('.crsl-items ul li').length > defaultVisibleElements) {
        //!!! need to detect how many items are visible and add the appropriate class to the li-s
        $('.crsl-items ul li').addClass('item-4');

        $('.crsl-items').carousel({
            visible: defaultVisibleElements,
            itemMinWidth: 200
        });
        
    } else {
        $('#nav-featured .previous').hide();
        $('#nav-featured .next').hide();
        //** add css for defining the width space  for each thumbnail
        $('.crsl-items ul li').addClass('item-' + $('.crsl-items ul li').length);
    }


});