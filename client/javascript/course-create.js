import $ from './jquery-global';
import 'jquery-validation';
import 'multiple-select';
import createCourseValidator from './validators/course-create.validator';
import { createCourse, createCourseImage, submitConfirmCourse } from './controllers/course.controller';
import { courseCreationUpdateLevel, createLevelImage, createLevelPdf, createLevelVideo, submitLevelCreate } from './controllers/level.controller';
import createCategoryValidator from './validators/create-category.validator';
import createLevelValidator from './validators/level-create.validator';
import createLessonValidator from './validators/lesson-create.validator';
import Swal from 'sweetalert2';
import { createLesson } from './controllers/lesson.controller';
import { createCourseCreateCategory } from './controllers/category.controller';
import LevelService from './services/level.service';

$(() => {
    // Create Course
    $('#course-create-form').validate(createCourseValidator);
    $('#course-create-form').on('submit', createCourse);

    // Confirm Course
    $('#confirm-course-btn').on('click', submitConfirmCourse);

    // Create Category
    $('#create-category-btn').on('click', function() {
        const modal = document.getElementById('category-create-modal');
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });

    $('#category-create-form').validate(createCategoryValidator);
    $('#category-create-form').on('submit', createCourseCreateCategory);


    // Create Level
    $('#create-level-btn').on('click', function() {
        const modal = document.getElementById('level-create-modal');
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });

    $('#level-create-form').validate(createLevelValidator);
    $('#level-create-form').on('submit', submitLevelCreate);

    // Update Level
    $(document).on('click', '.update-level-btn', async function() {
        const updateLevelId = document.getElementById('level-update-id');
        updateLevelId.value = this.getAttribute('ct-target');

        const response = await LevelService.findById(updateLevelId.value);
        console.log(response);
        $('#level-update-title').val(response.title);
        $('#level-update-description').val(response.description);
        $('#level-update-free').prop('checked', response.free);

        const modal = document.getElementById('level-update-modal');
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });

    $('#update-level-form').validate(createLevelValidator);
    $('#update-level-form').on('submit', courseCreationUpdateLevel);


    // Delete Level


    // Create Lesson
    $(document).on('click', '.create-lesson-btn', function() {
        const modal = document.getElementById('lesson-create-modal');
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();

        const createLessonLevel = document.getElementById('create-lesson-level');
        createLessonLevel.value = this.getAttribute('ct-target');
        console.log(createLessonLevel.value);
    });

    $('#create-lesson-form').validate(createLessonValidator);
    $('#create-lesson-form').on('submit', createLesson);

    // Update Lesson
    $(document).on('click', '.update-lesson-btn', function() {

        //const response = await findByIdService(updateLevelId.value);
        //console.log(response);
        //$('#edit-lesson-title').val(response.title);
        //$('#edit-lesson-description').val(response.description);
        

        const modal = document.getElementById('lesson-update-modal');
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });
    $('#update-lesson-form').validate(createLessonValidator);
    $('#update-lesson-form').on('submit', e => e.preventDefault());


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
        $('#price').val("0.00");
    });
/*
    const freeEditLevelCheckbox = document.getElementById('level-update-free');
    freeEditLevelCheckbox.addEventListener('change', function(event) {
        const EditLevelPriceGroup = document.getElementById('edit-level-price-group');
        if (event.target.checked) {
            EditLevelPriceGroup.classList.add('d-none');
        }
        else {
            EditLevelPriceGroup.classList.remove('d-none');
        }
    });
*/


    const uploadImage = document.getElementById('upload-image');
    uploadImage.addEventListener('change', createCourseImage);


    const createLessonVideo = document.getElementById('create-lesson-video');
    createLessonVideo.addEventListener('change', createLevelVideo);

    const createLessonImage = document.getElementById('create-lesson-image');
    createLessonImage.addEventListener('change', createLevelImage);

    const createLessonPdf = document.getElementById('create-lesson-pdf');
    createLessonPdf.addEventListener('change', createLevelPdf);

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

    $(document).on('click', '.delete-lesson-btn', async function() {
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
        
    $('#categories').multipleSelect({
        placeholder: 'Seleccionar',
        selectAll: false,
        width: '100%',
        filter: true
    });
});