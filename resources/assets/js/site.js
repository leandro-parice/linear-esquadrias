$(document).ready(function($) {
    $('#open-menu').click(function(event) {
        $('#menu-mobile').toggleClass('active');
    });

    $('#close-menu').click(function(event) {
        $('#menu-mobile').toggleClass('active');
    });

    $('.owl-banners').owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        items: 1,
        autoplay: true
    })

    $('.owl-gallery-target').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        dots: false,
        items: 1,
        autoplay: false
    })

    $('.owl-gallery-thumb').owlCarousel({
        loop: true,
        margin: 10,
        autoWidth: true,
        nav: true,
        dots: false,
        autoplay: true,
        responsive : {
            0 : {
                items: 2,
            },
            768 : {
                items: 4,
            }
        }
    })

    $('.project-footer').owlCarousel({
        loop: true,
        margin: 10,
        autoWidth: true,
        nav: true,
        dots: false,
        autoplay: true,
        responsive : {
            0 : {
                items: 2,
            },
            768 : {
                items: 4,
            }
        }
    })
});