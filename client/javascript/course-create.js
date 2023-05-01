import $ from './jquery-global';
import 'jquery-validation';
import 'multiple-select';
import CourseCreateValidator from './validators/course-create.validator';
import { backSection, createCourse, submitConfirmCourse } from './controllers/course.controller';
import { courseCreationUpdateLevel, createLevelImage, createLevelPdf, createLevelVideo, submitLevelCreate } from './controllers/level.controller';
import createCategoryValidator from './validators/create-category.validator';
import createLevelValidator from './validators/level-create.validator';
import createLessonValidator from './validators/lesson-create.validator';
import Swal from 'sweetalert2';
import { createLesson } from './controllers/lesson.controller';
import { createCourseCreateCategory } from './controllers/category.controller';
import LevelService from './services/level.service';
import { displayImageFile } from './controllers/image.controller';
import LevelView from './views/level.view';
import LessonService from './services/lesson.service';
import LessonView from './views/lesson.view';

$(() => {
    // Crear curso
    $('#course-create-form').validate(CourseCreateValidator);
    $('#course-create-form').on('submit', createCourse);

    $('#upload-image').on('change', async function(event) {
        await displayImageFile(event, '#upload-image', '#picture-box', '');
    });

    // Confirm Course
    $('#course-back-btn').on('click', backSection);
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
    $(document).on('click', '.update-lesson-btn', async function() {

        const id = $(this).attr('data-id');
        const response = await LessonService.findById(id);
        console.log(response);
        $('#edit-lesson-title').val(response.title);
        $('#edit-lesson-description').val(response.description);

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


    //$('#create-lesson-video').on('change', createLevelVideo);
    //$('#create-lesson-image').on('change', createLevelImage);
    //$('#create-lesson-pdf').on('change', createLevelPdf);

    $(document).on('click', '.delete-level-btn', async function() {
        const id = $(this).attr('data-id');
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
        if (feedback.isConfirmed) {
            await LevelService.delete(id);
            LevelView.deleteLevelSection(id);
        }
    });

    $(document).on('click', '.delete-lesson-btn', async function() {
        const id = $(this).attr('data-id');
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
        if (feedback.isConfirmed) {
            await LessonService.delete(id);
            LessonView.deleteLessonSection(id);
        }
    });
        
    $('#categories').multipleSelect({
        placeholder: 'Seleccionar',
        selectAll: false,
        width: '100%',
        filter: true
    });
});