import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import { createImage } from '../services/image.service';
import { readFileAsync } from '../utilities/file-reader';

export const createCourse = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    await Swal.fire({
        icon: 'success',
        title: '¡El curso fue creado con éxito!',
        confirmButtonText: 'Avanzar',
        confirmButtonColor: '#5650DE',
        background: '#FFFFFF',
        customClass: {
            confirmButton: 'btn btn-primary shadow-none rounded-pill'
        },
    });
    window.location.href = 'home.html';
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

        const allowedExtensions = /(jpg|jpeg|png|gif)$/i;
        if (!allowedExtensions.exec(file.type)) {
            pictureBox.src = defaultImage;
            courseCoverId.value = '';
            $("#course-creation-form").validate().element('#course-cover-id');
            return;
        }
        const dataUrl = await readFileAsync(file);
        pictureBox.src = dataUrl;

        const imageId = createImage();
        courseCoverId.value = imageId;
    }
    catch (exception) {
        pictureBox.src = defaultImage;
        courseCoverId.value = '';
    }
    $("#course-creation-form").validate().element('#course-cover-id');
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
    window.location.href = 'home.html';
}

export const deleteCourse = function(event) {

}

export const findAllByInstructor = function(event) {

}
