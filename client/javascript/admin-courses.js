import $ from './jquery-global';
import 'bootstrap';
import { approveCourses, denyCourses} from './controllers/course.controller';

$(async () => {
    $(document).on('click', '.btn-approve', async function() {
        const courseId = $(this).attr('data-id');
        await approveCourses(courseId);
    });
    
    $(document).on('click', '.btn-denied', async function() {
        const courseId = $(this).attr('data-id');
        await denyCourses(courseId);
    });
});