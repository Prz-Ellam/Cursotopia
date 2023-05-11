import $ from './jquery-global';
import 'bootstrap';
import { approveCourses, denyCourses} from './controllers/course.controller';

$(() => {
    $(document).on('click', '.btn-approve', async function() {
        const courseId = $(this).attr('data-id');
        await approveCourses(courseId);
        /* const response = await CourseService.approve({ approve: true }, courseId);
        console.log(response); */
    });
    
    $(document).on('click', '.btn-denied', async function() {
        const courseId = $(this).attr('data-id');
        await denyCourses(courseId);
        /* const response = await CourseService.approve({ approve: false }, courseId);
        console.log(response); */
    });
});