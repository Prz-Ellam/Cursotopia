import videojs from 'video.js';

var myCollapse = document.getElementById('level-1-collapse')
var bsCollapse = new bootstrap.Collapse(myCollapse, {
  toggle: true
});

videojs('level-video', {
    fluid: true
});
