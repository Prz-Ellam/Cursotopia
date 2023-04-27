import $ from 'jquery';
import Swal from 'sweetalert2';
import LessonService from './services/lesson.service';

//document.addEventListener('DOMContentLoaded', async function () {
  const params = new URLSearchParams(document.location.search);
  const lessonId = params.get('lesson') ?? null;

  document.querySelector('#level-video').onended = async function () {
    //if (this.played.end(0) - this.played.start(0) === this.duration) {
    Swal.fire({
      text: 'Video finalizado'
    });

    try {
      await LessonService.complete(lessonId);
    }
    catch (exception) {
      alert('Hubo errores');
    }

    console.log(lessonId);
    //}
  };

//});