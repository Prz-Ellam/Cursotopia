import $ from './jquery';
import 'owl.carousel';
import 'bootstrap';
import AOS from 'aos';

AOS.init({
    duration: 1000,
    easing: "ease-in-out",
    once: true,
    mirror: false
});

$('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
    dots: true,
    autoplay: true,
    autoplayTimeout: 10000,
    autoplayHoverPause: true, // Es molesto ver un curso y que el carousel se mueva
    responsive: {
        0: {
            items: 1
        },
        576: {
            items: 1
        },
        768: {
            items: 2
        },
        992: {
            items: 3
        },
        1200: {
            items: 3
        },
        1400: {
            items: 3
        },
        2000: {
            items: 6
        },
        3000: {
            items: 7
        },
        4000: {
            items: 8
        }
    }
});
