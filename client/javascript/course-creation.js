import $ from './jquery-global';
import 'jquery-validation';
import 'multiple-select';
import createCourseValidator from './validators/course-creation.validator';
import { createCourse, createCourseImage } from './controllers/course.controller';
import { createLevel } from './controllers/level.controller';
import createCategoryValidator from './validators/create-category.validator';
import createLevelValidator from './validators/create-level.validator';
import createLessonValidator from './validators/create-lesson.validator';
import Swal from 'sweetalert2';
import { createLesson } from './controllers/lesson.controller';

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

$('#course-creation-form').validate(createCourseValidator);
$('#create-category-form').validate(createCategoryValidator);

$('#create-level-form').validate(createLevelValidator);
$('#edit-level-form').validate(createLevelValidator);

$('#create-lesson-form').validate(createLessonValidator);
$('#edit-lesson-form').validate(createLessonValidator);

$('#course-creation-form').on('submit', createCourse);

const uploadImage = document.getElementById('upload-image');
uploadImage.addEventListener('change', createCourseImage);

const createCategoryForm = document.getElementById('create-category-form');
console.log(createCategoryForm);
createCategoryForm.addEventListener('submit', function(event) {
    event.preventDefault();
});

$(document).on('click', '.delete-level-btn', async function() {
    const feedback = await Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Estás seguro que deseas eliminar este nivel?',
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

/*
const deleteLevelBtn = document.getElementById('delete-level-btn');
deleteLevelBtn.addEventListener('click', async function() {
    const feedback = await Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Estás seguro que deseas eliminar este nivel?',
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
*/
const deleteLessonsBtn = Array.from(document.getElementsByClassName('delete-lesson-btn'));
deleteLessonsBtn.forEach(deleteLessonBtn => {
    deleteLessonBtn.addEventListener('click', async () => {
        const feedback = await Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Estás seguro que deseas eliminar este nivel?',
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
});
    
$('#add-level-btn').on('click', function() {
    const modal = document.getElementById('add-level');
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
});

$(document).on('click', '.add-lesson-btn', function() {
    const modal = document.getElementById('add-lesson');
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();

    const createLessonLevel = document.getElementById('create-lesson-level');
    createLessonLevel.value = this.getAttribute('ct-target');
});

$('#create-lesson-form').on('submit', createLesson);
$('#create-level-form').on('submit', createLevel);


$('#categories').multipleSelect({
    placeholder: 'Seleccionar',
    selectAll: false,
    width: '100%',
    filter: true
});
