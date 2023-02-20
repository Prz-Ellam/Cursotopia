import $ from './jquery-global';
import 'jquery-validation';
import 'multiple-select';
import 'bootstrap';
import createCourseValidator from './validators/create-course.validator';
import { createCourse } from './controllers/course.controller';

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

$('#create-course-form').validate(createCourseValidator);
$('#create-course-form').on('submit', createCourse);

$('#categories').multipleSelect({
    placeholder: 'Seleccionar',
    selectAll: false,
    width: '100%',
    filter: true
});