import AOS from 'aos';

AOS.init({
    duration: 1000,
    easing: "ease-in-out",
    once: true,
    mirror: false
});
/*
const categories = document.getElementById('categories');
const tagify = new Tagify(categories, {
    enforceWhitelist: true,
    mode : 'select',
    whitelist: [ 'Arte', 'Cine', 'Programación' ]
})

// bind events
tagify.on('add', onAddTag)
tagify.DOM.input.addEventListener('focus', onSelectFocus)

function onAddTag(e){
console.log(e.detail)
}

function onSelectFocus(e){
console.log(e)
}
*/

if (window.innerWidth > 991) {
    console.log(3);
}
else if (window.innerWidth > 767) {
    console.log(2);
}
else {
    console.log(1);
}