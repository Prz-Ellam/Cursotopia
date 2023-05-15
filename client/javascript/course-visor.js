import $ from 'jquery';
import 'bootstrap';
import { completeLesson } from './controllers/lesson.controller';

$(async () => {
    $('#level-video').attr('src', `api/v1/videos/${$('#level-video').attr('video-id')}`);

    $('#level-video').on('ended', completeLesson);
    $('#finish').on('click', completeLesson);
});