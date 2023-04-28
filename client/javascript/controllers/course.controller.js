import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import CourseService, { courseConfirmService, createCourseService } from '../services/course.service';
import { createImage } from '../services/image.service';
import { readFileAsync } from '../utilities/file-reader';

let opacity;

export const createCourse = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const formData = new FormData(this);
    const course = {
        title: formData.get('title'),
        description: formData.get('description'),
        price: Number.parseFloat(formData.get('price')),
        categories: formData.getAll('categories[]').map(category => Number.parseInt(category)),
        imageId: Number.parseInt(formData.get('imageId'))
    }

    console.log(course);

    const response = await CourseService.create(course);
    if (!response?.status) {
        let text = response.message ?? 'Parece que algo salió mal';
        if (response.message instanceof Object) {
            text = '';
            for (const [key, value] of Object.entries(response.message)) {
                text += `${value}<br>`;
            }
        }
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: text,
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }

    const createLevelCourseId = document.getElementById('create-level-course-id');
    createLevelCourseId.value = response.id;
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

    const current_fs = $('#course-section');
    const next_fs = $('#levels-section');

    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    next_fs.show();
    current_fs.animate({ opacity: 0 }, {
        step: function(now) {
            opacity = 1 - now;
                
            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });

            next_fs.css({'opacity': opacity});
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
    }
    catch (exception) {
        pictureBox.src = defaultImage;
        courseCoverId.value = '';
    }
    $("#course-create-form").validate().element('#course-cover-id');
}

export const updateCourse = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
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
    window.location.href = 'home';
}

export const deleteCourse = function(event) {

}

export const submitConfirmCourse = async function(event) {
    event.preventDefault();

    const courseId = document.getElementById('create-level-course-id').value;

    const response = await courseConfirmService(courseId);
    console.log(response);
    if (!response?.status) {
        let text = response.message ?? 'Parece que algo salió mal';
        if (response.message instanceof Object) {
            text = '';
            for (const [key, value] of Object.entries(response.message)) {
                text += `${value}<br>`;
            }
        }
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: text,
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
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
