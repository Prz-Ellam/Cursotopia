import videojs from 'video.js';

var myCollapse = document.getElementById('level-1-collapse')
var bsCollapse = new bootstrap.Collapse(myCollapse, {
  toggle: true
});

videojs('level-video', {
    fluid: true
});

document.querySelector("#level-video").onended = function() {
  if(this.played.end(0) - this.played.start(0) === this.duration) {
    console.log("Played all");
  }else {
    console.log("Some parts were skipped");
  }
}