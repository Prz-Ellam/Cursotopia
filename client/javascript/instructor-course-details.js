import $ from 'jquery';
import { deleteCourse } from './controllers/course.controller';

$(() => {
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });

    $('.btn-delete-course').on('click', deleteCourse); 
});