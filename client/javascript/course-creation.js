import $ from './jquery-global';
import 'jquery-validation';
import 'multiple-select';
import createCourseValidator from './validators/create-course.validator';
import { createCourse, createCourseImage } from './controllers/course.controller';
import { courseCreationUpdateLevel, createLevel } from './controllers/level.controller';
import createCategoryValidator from './validators/create-category.validator';
import createLevelValidator from './validators/create-level.validator';
import createLessonValidator from './validators/create-lesson.validator';
import Swal from 'sweetalert2';
import { createLesson } from './controllers/lesson.controller';
import { createCourseCreateCategory } from './controllers/category.controller';

// Create Course
const createCourseForm = document.getElementById('create-course-form');
$(createCourseForm).validate(createCourseValidator);
createCourseForm.addEventListener('submit', createCourse);


// Create Category
$('#create-category-btn').on('click', function() {
    const modal = document.getElementById('create-category-modal');
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
});

const createCategoryForm = document.getElementById('create-category-form');
$(createCategoryForm).validate(createCategoryValidator);
createCategoryForm.addEventListener('submit', createCourseCreateCategory);


// Create Level
$('#create-level-btn').on('click', function() {
    const modal = document.getElementById('create-level-modal');
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
});

const createLevelForm = document.getElementById('create-level-form');
$(createLevelForm).validate(createLevelValidator);
createLevelForm.addEventListener('submit', createLevel);


// Update Level
$(document).on('click', '.update-level-btn', function() {
    const modal = document.getElementById('update-level-modal');
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
});

const updateLevelForm = document.getElementById('update-level-form');
$(updateLevelForm).validate(createLevelValidator);
updateLevelForm.addEventListener('submit', courseCreationUpdateLevel);


// Delete Level


// Create Lesson
$(document).on('click', '.create-lesson-btn', function() {
    const modal = document.getElementById('create-lesson-modal');
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();

    const createLessonLevel = document.getElementById('create-lesson-level');
    createLessonLevel.value = this.getAttribute('ct-target');
});

const createLessonForm = document.getElementById('create-lesson-form');
$(createLessonForm).validate(createLessonValidator);
createLessonForm.addEventListener('submit', createLesson);


// Update Lesson
$(document).on('click', '.update-lesson-btn', function() {
    const modal = document.getElementById('update-lesson-modal');
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
});
const updateLessonForm = document.getElementById('update-lesson-form');
$(updateLessonForm).validate(createLessonValidator);
updateLessonForm.addEventListener('submit', e => e.preventDefault());


// Delete Lesson


const freeCourseCheckbox = document.getElementById('free-course-checkbox');
freeCourseCheckbox.addEventListener('change', function(event) {
    const priceGroup = document.getElementById('price-group');
    const price = document.getElementById('price');
    if (event.target.checked) {
        priceGroup.classList.add('d-none');
        price.setAttribute('disabled', 'disabled');
    }
    else {
        priceGroup.classList.remove('d-none');
        price.removeAttribute('disabled');
    }
});

const freeLevelCheckbox = document.getElementById('free-level-checkbox');
freeLevelCheckbox.addEventListener('change', function(event) {
    const levelPriceGroup = document.getElementById('level-price-group');
    if (event.target.checked) {
        levelPriceGroup.classList.add('d-none');
    }
    else {
        levelPriceGroup.classList.remove('d-none');
    }
});

const freeEditLevelCheckbox = document.getElementById('free-edit-level-checkbox');
freeEditLevelCheckbox.addEventListener('change', function(event) {
    const EditLevelPriceGroup = document.getElementById('edit-level-price-group');
    if (event.target.checked) {
        EditLevelPriceGroup.classList.add('d-none');
    }
    else {
        EditLevelPriceGroup.classList.remove('d-none');
    }
});



const uploadImage = document.getElementById('upload-image');
uploadImage.addEventListener('change', createCourseImage);



$(document).on('click', '.delete-level-btn', async function() {
    const feedback = await Swal.fire({
        title: '??Est??s seguro?',
        text: '??Est??s seguro que deseas eliminar este nivel?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#DD3333',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger shadow-none rounded-pill',
            cancelButton: 'btn btn-secondary shadow-none rounded-pill'
        }
    });
});

$(document).on('click', '.delete-lesson-btn', async function() {
    const feedback = await Swal.fire({
        title: '??Est??s seguro?',
        text: '??Est??s seguro que deseas eliminar este nivel?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#DD3333',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger shadow-none rounded-pill',
            cancelButton: 'btn btn-secondary shadow-none rounded-pill'
        }
    });
});
    
$('#categories').multipleSelect({
    placeholder: 'Seleccionar',
    selectAll: false,
    width: '100%',
    filter: true
});
