$(document).ready(function () {

    $('header.header').each(function () {
        var hold = $(this);
        var menu = hold.find('.toggle-menu');
        var menuClass = 'open-menu';
        menu.click(function () {
            hold.toggleClass(menuClass);
        });
    });


    $('.lessons').owlCarousel({
        margin: 30,
        animateOut: 'fadeOut',
        loop:true,
        nav:true,
        responsive:{
            0: {
                stagePadding : 40,
                items: 1
            },
            768: {
                stagePadding : 80,
                items: 2
            },
            992: {
                stagePadding : 0,
                items: 3
            }
        }
    });

    jQuery(document).ready(function($) {
        $('#play').mediaelementplayer();
    });


    $(document).on('click', "[data-url]:not([data-post])", function() {location.href = $(this).attr('data-url'); });
});
