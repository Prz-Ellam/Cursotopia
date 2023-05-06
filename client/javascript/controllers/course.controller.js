import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import { Toast } from '../utilities/toast';
import CourseService, { courseConfirmService, approveCourseService, denyCourseService } from '../services/course.service';
import { showNotApprovedCourses} from '../views/course.view';
import { readFileAsync } from '../utilities/file-reader';
import { showErrorMessage } from '../utilities/show-error-message';

let opacity;

export const createCourse = async function(event) {
    event.preventDefault();

    console.log($(this).serialize());
    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    const formData = new FormData(this);
    const course = {
        title: formData.get('title'),
        description: formData.get('description'),
        price: +Number.parseFloat($('#price').val()).toFixed(2),
        categories: formData.getAll('categories[]').map(category => Number.parseInt(category)),
    }

    const courseForm = new FormData();
    courseForm.append('payload', JSON.stringify(course));
    courseForm.append('image', formData.get('image'));

    const response = await CourseService.create(courseForm);
    //const response = { status: true, id: 1 }
    if (!response?.status) {
        await showErrorMessage(response);
        return;
    }

    $('#course-id').val(response.id);
    $('#create-level-course-id').val(response.id);

    await Swal.fire({
        icon: 'success',
        title: '¡La información fue añadida con éxito!',
        confirmButtonText: 'Avanzar',
        confirmButtonColor: '#5650DE',
        background: '#FFFFFF',
        customClass: {
            confirmButton: 'btn btn-primary shadow-none rounded-pill'
        },
    });

    // Ahora actualizara el curso en lugar de crearlo
    $(this).off('submit');
    $(this).on('submit', updateCourse);

    const currentFs = $('#course-section');
    const nextFs = $('#levels-section');

    $("#progressbar li").eq($("fieldset").index(nextFs)).addClass('active');

    nextFs.show();
    currentFs.animate({ opacity: 0 }, {
        step: function(now) {
            opacity = 1 - now;
                
            currentFs.css({
                'display': 'none',
                'position': 'relative'
            });

            nextFs.css({ 'opacity': opacity });
        },
        duration: 600
    });

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

export const backSection = function() {
    const currentFs = $('#levels-section');
    const nextFs = $('#course-section');

    $("#progressbar li").eq($("fieldset").index(nextFs)).addClass('active');

    nextFs.show();
    currentFs.animate({ opacity: 0 }, {
        step: function(now) {
            opacity = 1 - now;
                
            currentFs.css({
                'display': 'none',
                'position': 'relative'
            });

            nextFs.css({ 'opacity': opacity });
        },
        duration: 600
    });

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

export const createCourseImage = async function(event) {
    const pictureBox = document.getElementById('picture-box');
    const courseCoverId = document.getElementById('course-cover-id');
    const defaultImage = '';
    try {
        const files = Array.from(event.target.files);
        if (files.length === 0) {
            pictureBox.src = defaultImage;
            courseCoverId.value = '';
            $("#course-creation-form").validate().element('#course-cover-id');
            return;
        }
        const file = files[0];

        const size = parseFloat((file.size / 1024.0 / 1024.0).toFixed(2));
        if (size > 8.0) {
            await Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'La imagen es muy pesada',
                confirmButtonColor: "#dc3545",
            });
            pictureBox.src = defaultImage;
            courseCoverId.value = '';
            $("#course-creation-form").validate().element('#course-cover-id');
            return;
        }

        const allowedExtensions = [ 'image/jpg', 'image/jpeg', 'image/png' ];
        if (!allowedExtensions.includes(file.type)) {
            pictureBox.src = defaultImage;
            courseCoverId.value = '';
            $("#course-creation-form").validate().element('#course-cover-id');
            return;
        }
        const dataUrl = await readFileAsync(file);
        pictureBox.src = dataUrl;
/*
        const formData = new FormData();
        formData.append('image', file, file.name);

        if (!courseCoverId.value) {
            const response = await createImage(formData);
            const imageId = response.id;
            courseCoverId.value = imageId;
        }
        else {
            const response = await updateImageService(formData, courseCoverId.value);
        }
        */
    }
    catch (exception) {
        pictureBox.src = defaultImage;
        courseCoverId.value = '';
    }
    $("#course-create-form").validate().element('#course-cover-id');
}

export const updateCourse = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    const formData = new FormData(this);
    const id = formData.get('courseId');
    const course = {
        title: formData.get('title'),
        description: formData.get('description'),
        price: Number.parseFloat(formData.get('price')),
        categories: formData.getAll('categories[]').map(category => Number.parseInt(category)),
    }

    const response = await CourseService.update(id, JSON.stringify(course));
    if (!response?.status) {
        await showErrorMessage(response);
        return;
    }

    await Swal.fire({
        icon: 'success',
        title: '¡El curso fue actualizado con éxito!',
        confirmButtonText: 'Avanzar',
        confirmButtonColor: '#5650DE',
        background: '#FFFFFF',
        customClass: {
            confirmButton: 'btn btn-primary shadow-none rounded-pill'
        },
    });
    
    const currentFs = $('#course-section');
    const nextFs = $('#levels-section');

    $("#progressbar li").eq($("fieldset").index(nextFs)).addClass('active');

    nextFs.show();
    currentFs.animate({ opacity: 0 }, {
        step: function(now) {
            opacity = 1 - now;
                
            currentFs.css({
                'display': 'none',
                'position': 'relative'
            });

            nextFs.css({ 'opacity': opacity });
        },
        duration: 600
    });

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

export const deleteCourse = async function(event) {
    const feedback = await Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Estás seguro que deseas deshabilitar este curso?',
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
        // TODO: uri estatica
        // TODO: quitar el boton de deshabilitar si ya esta deshabilitado
        const params = new URLSearchParams(window.location.search);
        const id = params.get('course_id');
        await CourseService.delete(id);
        window.location.href = 'home';
    }
}

export const submitConfirmCourse = async function(event) {
    event.preventDefault();

    const courseId = document.getElementById('create-level-course-id').value;
    const response = await courseConfirmService(courseId);
    if (!response?.status) {
        await showErrorMessage(response);
        return;
    }

    await Swal.fire({
        icon: 'success',
        title: '¡El curso está listo!',
        text: 'El contenido del curso ha sido añadido, un administrador te informará cuando se apruebe tu curso y que todos puedan verlo',
        confirmButtonText: 'Continuar',
        confirmButtonColor: '#5650DE',
        background: '#FFFFFF',
        customClass: {
            confirmButton: 'btn btn-primary shadow-none rounded-pill'
        },
    });
    window.location.href = '/home';
}

export const findAllByInstructor = function(event) {

}

export const approveCourses = async function(courseId) {

    const response = await approveCourseService(courseId);
    if (response?.status) {
        $('#notApprovedCourses').empty();
        const notApprovedCourses = await CourseService.findnotApproved(courseId);
        if (notApprovedCourses?.status) {
            const coursesNotApproved = notApprovedCourses.courses;
            console.log(coursesNotApproved);
            coursesNotApproved.forEach(course => {
                showNotApprovedCourses(course);
            });
        }
        Toast.fire({
            icon: 'success',
            title: 'El curso ha sido aprobado'
        });
        return;
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }
}

export const denyCourses = async function(courseId) {

    const response = await denyCourseService(courseId);
    if (response?.status) {
        $('#notApprovedCourses').empty();
        const notApprovedCourses = await CourseService.findnotApproved(courseId);
        if (notApprovedCourses?.status) {
            const coursesNotApproved = notApprovedCourses.courses;
            coursesNotApproved.forEach(course => {
                showNotApprovedCourses(course);
            });
        }
        Toast.fire({
            icon: 'error',
            title: 'El curso ha sido denegado'
        });
        return;
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }
}
