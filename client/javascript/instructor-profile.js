import $ from 'jquery';
import 'bootstrap';
import AOS from 'aos';

$(async () => {
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });
});
