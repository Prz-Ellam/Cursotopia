import Swal from 'sweetalert2';
import LessonService from '@/services/lesson.service';
import { hideModal } from '@/utilities/modal';
import { showErrorMessage } from '@/utilities/show-error-message';
import { Toast, ToastTopEnd } from '@/utilities/toast';
import LessonView from '@/views/lesson.view';

export const createLesson = async function(event) {
    event.preventDefault();
    
    const isFormValid = $(this).valid();
    if (!isFormValid) {
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Formulario no válido'
        });
        return;
    }
    
    const levelId = document.getElementById('create-lesson-level').value;
    const title = document.getElementById('create-lesson-title').value;
    const video = document.getElementById('create-lesson-video').value;

    const formData = new FormData(this);
    const lesson = {
        title: formData.get('title'),
        description: formData.get('description'),
        levelId: Number.parseInt(formData.get('levelId')),
        link: {
            name: formData.get('link-title'),
            url: formData.get('link-url')
        }
    }

    console.log(lesson);

    const lessonForm = new FormData();
    lessonForm.append('payload', JSON.stringify(lesson));
    const videoFile = formData.get('video');
    const imageFile = formData.get('image');
    const documentFile = formData.get('document');
    
    if (videoFile.size > 0) {
        lessonForm.append('video', videoFile);
    }

    if (imageFile.size > 0) {
        lessonForm.append('image', imageFile);
    }

    if (documentFile.size > 0) {
        lessonForm.append('document', documentFile);
    }

    $('#create-lesson-btn').prop('disabled', true);
    $('#create-lesson-spinner').removeClass('d-none');

    const response = await LessonService.create(lessonForm);

    $('#create-lesson-spinner').addClass('d-none');
    $('#create-lesson-btn').prop('disabled', false);

    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    hideModal('#lesson-create-modal');

    Toast.fire({
        icon: 'success',
        title: 'La lección ha sido agregada con éxito'
    });

    LessonView.createLessonSection({ id: response.id, level: levelId, title, video });

    document.querySelector('#create-lesson-form').reset();
}

export const courseEditionCreateLesson = async function(event) {
    event.preventDefault();
    
    const isFormValid = $(this).valid();
    if (!isFormValid) {
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Formulario no válido'
        });
        return;
    }

    hideModal('#lesson-create-modal');
    
    const levelId = document.getElementById('create-lesson-level').value;
    const title = document.getElementById('create-lesson-title').value;
    const video = document.getElementById('create-lesson-video').value;

    courseCreationCreateLessonSection({ level: levelId, title, video });

    const createLessonForm = document.getElementById('create-lesson-form');
    createLessonForm.reset();
}

export const updateLesson = async function(event) {
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
    const id = formData.get('id');
    const lesson = {
        title: formData.get('title'),
        description: formData.get('description')
    };

    $('#update-lesson-btn').prop('disabled', true);
    $('#update-lesson-spinner').removeClass('d-none');

    const response = await LessonService.update(lesson, id);

    $('#update-lesson-spinner').addClass('d-none');
    $('#update-lesson-btn').prop('disabled', false);

    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    hideModal('#lesson-update-modal');

    Toast.fire({
        icon: 'success',
        title: 'La lección ha sido actualizada con éxito'
    });

    LessonView.updateLessonSection({ 
        id,
        title: lesson.title
    });

    document.querySelector('#update-lesson-form').reset();
}

export const completeLesson = async function() {
    const params = new URLSearchParams(document.location.search);
    const lessonId = params.get('lesson') ?? null;

    const response = await LessonService.complete(lessonId);
    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    await Swal.fire({
        icon: 'success',
        title: 'Lección completada',
        confirmButtonText: 'Avanzar',
        confirmButtonColor: '#5650DE',
        background: '#FFFFFF',
        customClass: {
            confirmButton: 'btn btn-primary shadow-none rounded-pill'
        },
    });

    location.reload();
}