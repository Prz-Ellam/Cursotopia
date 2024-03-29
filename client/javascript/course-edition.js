import $ from './jquery-global';
import 'jquery-validation';
import 'multiple-select';
import { updateCourse } from './controllers/course.controller';
import updateCourseValidator from './validators/course-update.validator';
import { changeImage } from './controllers/image.controller';
import { showModal } from './utilities/modal';

$(async () => {
    // Update Course
    $('#update-course-form').validate(updateCourseValidator);
    $('#update-course-form').on('submit', updateCourse);

    $('#upload-image').on('change', function(event) {
        changeImage(event, '#upload-image', '#picture-box', '');
    });

    // Create Category
    $('#create-category-btn').on('click', function() {
        showModal('#create-category-modal');
    });


    const freeCourseCheckbox = document.getElementById('free-course-checkbox');
    if (freeCourseCheckbox.checked) {
        $('#update-course-price').attr('disabled', true);
        $('#update-course-price').val("0.00");
    }

    freeCourseCheckbox.addEventListener('change', function(event) {
        const priceGroup = document.getElementById('price-group');
        const price = document.getElementById('price');
        console.log('h');
        if (event.target.checked) {
            $('#update-course-price').attr('disabled', true);
            $('#update-course-price').val("0.00");
        }
        else {
            $('#update-course-price').attr('disabled', false);
            $('#update-course-price').val("0.01");
        }
    });

    //const createCategoryForm = document.getElementById('create-category-form');
    //$(createCategoryForm).validate(createCategoryValidator);
    //createCategoryForm.addEventListener('submit', updateCourseCreateCategory);

/*
    // Create Level
    $('#create-level-btn').on('click', function() {
        const modal = document.getElementById('create-level-modal');
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });

    const createLevelForm = document.getElementById('create-level-form');
    $(createLevelForm).validate(createLevelValidator);
    createLevelForm.addEventListener('submit', courseEditionCreateLevel);

    // Update Level
    $(document).on('click', '.update-level-btn', function() {
        const modal = document.getElementById('update-level-modal');
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });

    const updateLevelForm = document.getElementById('update-level-form');
    $(updateLevelForm).validate(createLevelValidator);
    updateLevelForm.addEventListener('submit', courseEditionUpdateLevel);

    // Delete Level
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
    createLessonForm.addEventListener('submit', courseEditionCreateLesson);

    // Update Lesson
    $(document).on('click', '.update-lesson-btn', function() {
        const modal = document.getElementById('lesson-update-modal');
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    });
    const updateLessonForm = document.getElementById('update-lesson-form');
    $(updateLessonForm).validate(createLessonValidator);
    updateLessonForm.addEventListener('submit', e => e.preventDefault());

    // Delete Lesson
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

    const uploadImage = document.getElementById('upload-image');
    uploadImage.addEventListener('change', createCourseImage);

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
    */

    $('#categories').multipleSelect({
        placeholder: 'Seleccionar',
        selectAll: false,
        width: '100%',
        filter: true
    });
});