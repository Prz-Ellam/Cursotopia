import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import { Toast, ToastTopEnd } from '../utilities/toast';
import CourseService from '@/services/course.service';
import { showNotApprovedCourses} from '../views/course.view';
import { readFileAsync } from '../utilities/file-reader';
import { showErrorMessage } from '../utilities/show-error-message';
import { changeImage } from './image.controller';
import VideoService from '@/services/video.service';
import DocumentService from '@/services/document.service';
import ImageService from '@/services/image.service';
import LinkService from '@/services/link.service';

let opacity;

export const submitCreateCourse = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Formulario no válido'
        });
        return;
    }

    const formData = new FormData(this);
    const course = {
        title: formData.get('title'),
        description: formData.get('description'),
        price: $('#price').val(),
        categories: formData.getAll('categories[]').map(category => Number.parseInt(category)),
    }

    const courseForm = new FormData();
    courseForm.append('payload', JSON.stringify(course));
    courseForm.append('image', formData.get('image'));

    $('#course-create-btn').prop('disabled', true);
    $('#course-create-spinner').removeClass('d-none');

    const response = await CourseService.create(courseForm);

    $('#course-create-spinner').addClass('d-none');
    $('#course-create-btn').prop('disabled', false);
    
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
    $('#course-cover-id').val(response.imageId);
    $('#upload-image').off('change');
    $('#upload-image').on('change', function(event) {
        changeImage(event, '#upload-image', '#picture-box', '');
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
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Formulario no válido'
        });
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
        const params = new URLSearchParams(window.location.search);
        const id = params.get('course_id');
        const response = await CourseService.delete(id);
        if (!response?.status) {
            showErrorMessage(response);
            return;
        }

        await Swal.fire({
            icon: 'success',
            title: 'El curso ha sido eliminado',
            confirmButtonText: 'Avanzar',
            confirmButtonColor: '#5650DE',
            background: '#FFFFFF',
            customClass: {
                confirmButton: 'btn btn-primary shadow-none rounded-pill'
            },
        });

        window.location.href = '/home';
    }
}

export const submitConfirmCourse = async function(event) {
    event.preventDefault();

    const courseId = document.getElementById('create-level-course-id').value;
    const response = await CourseService.confirm(courseId);
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
    const response = await CourseService.approve(courseId);
    if (!response?.status) {
        await showErrorMessage(response);
        return;
    }

    const notApprovedCourses = await CourseService.findnotApproved(courseId);
    if (!notApprovedCourses?.status) {
        showErrorMessage({ message: 'Ocurrio un error inesperado' });
        return;
    }

    $('#notApprovedCourses').empty();
    const coursesNotApproved = notApprovedCourses.courses;
    coursesNotApproved.forEach(course => {
        showNotApprovedCourses(course);
    });

    Toast.fire({
        icon: 'success',
        title: 'El curso ha sido aprobado'
    });
}

export const denyCourses = async function(courseId) {
    const response = await CourseService.deny(courseId);
    if (!response?.status) {
        await showErrorMessage(response);
        return;
    }

    const notApprovedCourses = await CourseService.findnotApproved(courseId);
    if (!notApprovedCourses?.status) {
        showErrorMessage({ message: 'Ocurrio un error inesperado' });
        return;
    }
    
    $('#notApprovedCourses').empty();
    const coursesNotApproved = notApprovedCourses.courses;
    coursesNotApproved.forEach(course => {
        showNotApprovedCourses(course);
    });

    Toast.fire({
        icon: 'error',
        title: 'El curso ha sido denegado'
    });
}

export const updateVideo = async function(event) {
    const videoId = $('#delete-video-btn').attr('data-id');
    const files = Array.from(event.target.files);
    const video = files[0];

    const form = new FormData();
    form.append('video', video);

    if (videoId) {
        await VideoService.update(videoId, form);
    }
    else {
        const lessonId = $('#lesson-update-id').val();
        const response = await VideoService.putLessonVideo(lessonId, form);

        if (response.status) {
            $('#delete-video-btn').attr('data-id', response.id);
        }
    }
    
    console.log('Evento');
}

export const updateDocument = async function(event) {
    const documentId = $('#delete-document-btn').attr('data-id');
    const files = Array.from(event.target.files);
    const document = files[0];

    const form = new FormData();
    form.append('document', document);

    if (documentId) {
        await DocumentService.update(documentId, form);
    }
    else {
        const lessonId = $('#lesson-update-id').val();
        const response = await DocumentService.putLessonDocument(lessonId, form);

        if (response.status) {
            $('#delete-document-btn').attr('data-id', response.id);
        }
    }
    
    console.log('Evento');
}

export const updateImage = async function(event) {
    const imageId = $('#delete-image-btn').attr('data-id');
    const files = Array.from(event.target.files);
    const image = files[0];

    const form = new FormData();
    form.append('image', image);

    if (imageId) {
        await ImageService.update(form, imageId);
    }
    else {
        const lessonId = $('#lesson-update-id').val();
        const response = await ImageService.putLessonImage(lessonId, form);

        if (response.status) {
            $('#delete-image-btn').attr('data-id', response.id);
        }
    }
    
    console.log('Evento');
}

export const updateLink = async function(event) {
    const linkId = $('#delete-link-btn').attr('data-id');

    console.log(linkId);

    const title = $('#edit-lesson-link-title').val();
    const address = $('#edit-lesson-link-address').val();
    const link = {
        name: title,
        address
    }

    if (linkId) {
        await LinkService.update(link, linkId);
    }
    else {
        const lessonId = $('#lesson-update-id').val();
        const response = await LinkService.putLessonLink(lessonId, link);

        if (response.status) {
            $('#delete-link-btn').attr('data-id', response.id);
        }
    }
}

export const deleteVideo = async function(event) {
    const videoId = $('#delete-video-btn').attr('data-id');
    const response = await VideoService.delete(videoId);
    if (response.status) {
        $('#delete-video-btn').attr('data-id', null);
    }
}

export const deleteImage = async function(event) {
    const imageId = $('#delete-image-btn').attr('data-id');
    const response = await ImageService.delete(imageId);
    if (response.status) {
        $('#delete-image-btn').attr('data-id', null);
    }
}

export const deleteDocument = async function(event) {
    const documentId = $('#delete-document-btn').attr('data-id');
    const response = await DocumentService.delete(documentId);
    if (response.status) {
        $('#delete-document-btn').attr('data-id', null);
    }
}

export const deleteLink = async function(event) {
    const linkId = $('#delete-link-btn').attr('data-id');
    const response = await LinkService.delete(linkId);
    if (response.status) {
        $('#delete-link-btn').attr('data-id', null);
        $('#edit-lesson-link-title').val('');
        $('#edit-lesson-link-address').val('');
    }
}