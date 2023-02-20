import $ from 'jquery';
import 'jquery-validation';
import createCourseValidator from './validators/create-course.validator';

$('#add-course-form').validate(createCourseValidator);