import $ from './jquery-global';
import 'jquery-validation';
import 'multiple-select';
import 'bootstrap';
import createCourseValidator from './validators/create-course.validator';
import { createCourse } from './controllers/course.controller';
import createCategoryValidator from './validators/create-category.validator';
import createLevelValidator from './validators/create-level.validator';
import createLessonValidator from './validators/create-lesson.validator';

const freeCourseCheckbox = document.getElementById('free-course-checkbox');
freeCourseCheckbox.addEventListener('change', function(event) {
    const priceGroup = document.getElementById('price-group');
    if (event.target.checked) {
        priceGroup.classList.add('d-none');
    }
    else {
        priceGroup.classList.remove('d-none');
    }
});

$('#create-category-form').validate(createCategoryValidator);
$('#create-course-form').validate(createCourseValidator);
$('#create-level-form').validate(createLevelValidator);
$('#create-lesson-form').validate(createLessonValidator);

$('#create-course-form').on('submit', createCourse);

const createCategoryForm = document.getElementById('create-category-form');
console.log(createCategoryForm);
createCategoryForm.addEventListener('submit', function(event) {
    event.preventDefault();
});

$('#create-lesson-form').on('submit', function(event) {
    event.preventDefault();
});

$('#categories').multipleSelect({
    placeholder: 'Seleccionar',
    selectAll: false,
    width: '100%',
    filter: true
});