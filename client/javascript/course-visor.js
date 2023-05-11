import $ from 'jquery';
import Swal from 'sweetalert2';
import LessonService from './services/lesson.service';

$(function() {
  const params = new URLSearchParams(document.location.search);
  const lessonId = params.get('lesson') ?? null;
  $('#level-video').attr('src', `api/v1/videos/${ $('#level-video').attr('video-id') }`);

  $('#level-video').on('ended', async function() {
    try {
      await LessonService.complete(lessonId);
      await Swal.fire({
        text: 'Video finalizado'
      });

      location.reload();
    } catch (exception) {
      alert('Hubo errores');
    }
  });
  

  $('#finish').on('click', async function() {
    try {
      await LessonService.complete(lessonId);
      location.reload();
    }
    catch (exception) {
      console.error('Hubo errores');
    }
  });

});