import Swal from "sweetalert2";
import LessonService, { createLessonService } from "../services/lesson.service";
import { showErrorMessage } from "../utilities/show-error-message";
import { Toast } from "../utilities/toast";
import LessonView from "../views/lesson.view";

export const createLesson = async function(event) {
    event.preventDefault();
    
    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    const modal = document.getElementById('lesson-create-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();
    
    const levelId = document.getElementById('create-lesson-level').value;
    const title = document.getElementById('create-lesson-title').value;
    const video = document.getElementById('create-lesson-video').value;

    const formData = new FormData(this);
    const lesson = {
        title: formData.get('title'),
        description: formData.get('description'),
        levelId: Number.parseInt(formData.get('levelId')),
        //videoId: Number.parseInt(formData.get('video')),
        //imageId: Number.parseInt(formData.get('image')),
        //documentId: Number.parseInt(formData.get('document')),
        //linkId: Number.parseInt(formData.get('link'))
    }

    const lessonForm = new FormData();
    lessonForm.append('payload', JSON.stringify(lesson));
    lessonForm.append('video', formData.get('video'));
    lessonForm.append('image', formData.get('image'));
    lessonForm.append('document', formData.get('document'));
    
    const response = await LessonService.create(lessonForm);
    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    Toast.fire({
        icon: 'success',
        title: 'La lección ha sido agregada con éxito'
    });

    LessonView.createLessonSection({ id: response.id, level: levelId, title, video });

    const createLessonForm = document.getElementById('create-lesson-form');
    createLessonForm.reset();
}

export const courseEditionCreateLesson = async function(event) {
    event.preventDefault();
    
    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    const modal = document.getElementById('lesson-create-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();
    
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
        return;
    }

    const modal = document.getElementById('lesson-update-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();

    const id = /* ??? */ null;
    const formData = new FormData(this);
    const lesson = {
        title: formData.get('title'),
        description: formData.get('description')
    };

    await LessonService.update(lesson, id);
}