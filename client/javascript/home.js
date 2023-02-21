import $ from './jquery-global';
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
    nav: true,
    stagePadding: 5,
    navText: [ '<i class="text-white bx bx-chevron-left"></i>', '<i class="text-white bx bx-chevron-right"></i>' ],
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

const courseCards = document.getElementsByClassName('course-card');
const arrayCourseCards = Array.from(courseCards);
arrayCourseCards.forEach(courseCard => {
    courseCard.addEventListener('click', () => {
        window.location.href = '/views/course-details.html';
    });
});