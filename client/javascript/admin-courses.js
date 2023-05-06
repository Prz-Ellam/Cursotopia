import $ from './jquery-global';
import 'bootstrap';
import CourseService from './services/course.service';
import { approveCourses, denyCourses} from './controllers/course.controller';

$(() => {
    $(document).on('click', '.btn-approve', async function() {
        const courseId = $(this).attr('data-id');
        approveCourses(courseId);
        /* const response = await CourseService.approve({ approve: true }, courseId);
        console.log(response); */
    });
    
    $(document).on('click', '.btn-denied', async function() {
        const courseId = $(this).attr('data-id');
        denyCourses(courseId);
        /* const response = await CourseService.approve({ approve: false }, courseId);
        console.log(response); */
    });
});