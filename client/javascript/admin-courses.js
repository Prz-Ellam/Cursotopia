import $ from './jquery-global';
import CourseService from './services/course.service';

$(() => {
    $(document).on('click', '.btn-approve', async function() {
        const courseId = $(this).attr('data-id');
        const response = await CourseService.approve({ approve: true }, courseId);
        console.log(response);
    });
    
    $(document).on('click', '.btn-denied', async function() {
        const courseId = $(this).attr('data-id');
        const response = await CourseService.approve({ approve: false }, courseId);
        console.log(response);
    });
});