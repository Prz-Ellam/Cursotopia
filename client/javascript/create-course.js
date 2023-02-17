import $ from './jquery';
import 'jquery-validation';
import createCourseValidator from './validators/create-course.validator';
import { createCourse } from './controllers/course.controller';

$('#create-course-form').validate(createCourseValidator);
$('#create-course-form').on('submit', createCourse);