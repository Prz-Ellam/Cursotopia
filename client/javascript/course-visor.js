import Swal from 'sweetalert2';
import videojs from 'video.js';

document.querySelector('#level-video').onended = async function () {
  //if (this.played.end(0) - this.played.start(0) === this.duration) {
  Swal.fire({
    text: 'Video finalizado'
  });

  // Dar por vista le lección
  const params = new URLSearchParams(document.location.search);
  const lessonId = params.get('lesson') ?? null;

  try {
    await CourseService.completeLesson(lessonId);
  }
  catch (exception) {

  }

  console.log(lessonId);
  //}
};

videojs('level-video', {
  fluid: true
});