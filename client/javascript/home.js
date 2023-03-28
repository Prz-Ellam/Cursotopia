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

const observer = new IntersectionObserver(function(entries) {
	if(entries[0].isIntersecting === true) {
		const counters = document.getElementsByClassName('counter');
        Array.from(counters).forEach(counter => {
            const intervalValue = 5000;
            let startValue = 0;
            let endValue = Number.parseInt(counter.getAttribute('data-val'));
            if (endValue !== 0) {
                let duration = Math.floor(intervalValue / endValue);
                const interval = setInterval(() => {
                    startValue++;
                    counter.textContent = startValue;
                    if (startValue === endValue) {
                        clearInterval(interval);
                    }
                }, duration);   
            }
        });
        observer.unobserve(document.querySelector("#info-section"));
    }
}, { threshold: [0] });

observer.observe(document.querySelector("#info-section"));



