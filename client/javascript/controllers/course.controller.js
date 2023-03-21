import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import { createCourseService } from '../services/course.service';
import { createImage } from '../services/image.service';
import { readFileAsync } from '../utilities/file-reader';

let opacity;

export const createCourse = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }
    console.log('Aqui');

    const formData = new FormData(this);
    const course = {
        title: formData.get('title'),
        description: formData.get('description'),
        price: parseFloat(formData.get('price')),
        categories: formData.getAll('categories[]').map(category => parseInt(category)),
        imageId: formData.get('imageId')
    }

    const response = await createCourseService(course);
    if (response.status) {
        const createLevelCourseId = document.getElementById('create-level-course-id');
        createLevelCourseId.value = response.id;
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
        //window.location.href = 'home';
    }
    else {
        return;
    }

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

    window.scrollTo({ top: 0, behavior: 'smooth' })
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
    $("#create-course-form").validate().element('#course-cover-id');
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

export const findAllByInstructor = function(event) {

}
