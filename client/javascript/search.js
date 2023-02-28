import AOS from 'aos';

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 1000,
        easing: "ease-in-out",
        once: true,
        mirror: false
    });
});