import $ from 'jquery';
import Swal from 'sweetalert2';
import LessonService from './services/lesson.service';

$(function() {
  const params = new URLSearchParams(document.location.search);
  const lessonId = params.get('lesson') ?? null;
  $('#level-video').attr('src', `api/v1/videos/${ $('#level-video').attr('video-id') }`);

  $('#level-video').on('ended', async function() {
    Swal.fire({
      text: 'Video finalizado'
    });
  
    try {
      await LessonService.complete(lessonId);
    } catch (exception) {
      alert('Hubo errores');
    }
  
    console.log(lessonId);
  });
  

  $('#finish').on('click', async function() {
    try {
      await LessonService.complete(lessonId);
    }
    catch (exception) {
      alert('Hubo errores');
    }
  });

});