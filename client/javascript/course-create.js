import $ from './jquery-global';
import 'jquery-validation';
import 'multiple-select';
import 'bootstrap';
import CourseCreateValidator from './validators/course-create.validator';
import { backSection, deleteDocument, deleteImage, deleteLink, deleteVideo, submitConfirmCourse, submitCreateCourse, updateDocument, updateImage, updateLink, updateVideo } from './controllers/course.controller';
import { courseCreationUpdateLevel, submitLevelCreate } from './controllers/level.controller';
import CreateCategoryValidator from './validators/category-create.validator';
import createLevelValidator from './validators/level-create.validator';
import createLessonValidator from './validators/lesson-create.validator';
import Swal from 'sweetalert2';
import { createLesson, updateLesson } from './controllers/lesson.controller';
import { submitCategory } from './controllers/category.controller';
import LevelService from './services/level.service';
import { displayImageFile } from './controllers/image.controller';
import LevelView from './views/level.view';
import LessonService from './services/lesson.service';
import LessonView from './views/lesson.view';
import { showModal } from './utilities/modal';

$(async () => {
    // Crear curso
    $('#course-create-form').validate(CourseCreateValidator);
    $('#course-create-form').on('submit', submitCreateCourse);

    $('#upload-image').on('change', async function(event) {
        await displayImageFile(event, '#upload-image', '#picture-box', '');
    });

    // Confirm Course
    $('#course-back-btn').on('click', backSection);
    $('#confirm-course-btn').on('click', submitConfirmCourse);

    // Create Category
    $('#create-category-btn').on('click', function() {
        showModal('#category-create-modal');
    });

    $('#category-create-form').validate(CreateCategoryValidator);
    $('#category-create-form').on('submit', submitCategory);


    // Create Level
    $('#create-level-btn').on('click', function() {
        showModal('#level-create-modal');
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

        showModal('#level-update-modal');
    });

    $('#update-level-form').validate(createLevelValidator);
    $('#update-level-form').on('submit', courseCreationUpdateLevel);


    // Delete Level


    // Create Lesson
    $(document).on('click', '.create-lesson-btn', function() {
        showModal('#lesson-create-modal');

        const createLessonLevel = document.getElementById('create-lesson-level');
        createLessonLevel.value = this.getAttribute('ct-target');
        console.log(createLessonLevel.value);
    });

    $('#create-lesson-form').validate(createLessonValidator);
    $('#create-lesson-form').on('submit', createLesson);

    // Update Lesson
    $(document).on('click', '.update-lesson-btn', async function() {

        const id = $(this).attr('data-id');
        console.log(id);

        $('#lesson-update-id').val(id);

        const response = await LessonService.findById(id);
        console.log(response);
        $('#edit-lesson-title').val(response.title);
        $('#edit-lesson-description').val(response.description);

        $('#delete-video-btn').attr('data-id', response.videoId);
        $('#delete-image-btn').attr('data-id', response.imageId);
        $('#delete-document-btn').attr('data-id', response.documentId);
        $('#delete-link-btn').attr('data-id', response.linkId);

        showModal('#lesson-update-modal');
    });
    
    $('#update-lesson-form').validate(createLessonValidator);
    $('#update-lesson-form').on('submit', updateLesson);


    // Delete Lesson


    const freeCourseCheckbox = document.getElementById('free-course-checkbox');
    freeCourseCheckbox.addEventListener('change', function(event) {
        const priceGroup = document.getElementById('price-group');
        const price = document.getElementById('price');
        if (event.target.checked) {
            $('#price').attr('disabled', true);
            $('#level-create-free').attr('disabled', true);
            $('#level-create-free').attr('checked', true);
            $('#level-update-free').attr('disabled', true);
            $('#level-update-free').attr('checked', true);
            $('#price').val("0.00");
            //priceGroup.classList.add('d-none');
            //price.setAttribute('disabled', 'disabled');
        }
        else {
            $('#price').attr('disabled', false);
            $('#level-create-free').attr('disabled', false);
            $('#level-create-free').attr('checked', false);
            $('#level-update-free').attr('disabled', false);
            $('#level-update-free').attr('checked', false);
            //priceGroup.classList.remove('d-none');
            //price.removeAttribute('disabled');
            $('#price').val("0.01");
        }
    });

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
            const response = await LevelService.delete(id);
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
            const response = await LessonService.delete(id);
            LessonView.deleteLessonSection(id);
        }
    });

    $('#update-lesson-video').on('change', updateVideo);
    $('#update-lesson-document').on('change', updateDocument);
    $('#update-lesson-image').on('change', updateImage);
    $('#update-link-btn').on('click', updateLink);

    $('#delete-video-btn').on('click', deleteVideo);
    $('#delete-document-btn').on('click', deleteDocument);
    $('#delete-image-btn').on('click', deleteImage);
    $('#delete-link-btn').on('click', deleteLink);

    $('#categories').multipleSelect({
        placeholder: 'Seleccionar',
        selectAll: false,
        width: '100%',
        filter: true
    });
});