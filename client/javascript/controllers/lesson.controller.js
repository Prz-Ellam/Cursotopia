import { Modal } from "bootstrap";
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

    const response = await LessonService.create(lessonForm);

    const modal = document.getElementById('lesson-create-modal');
    const modalInstance = Modal.getInstance(modal);
    modalInstance.hide();

    if (!response?.status) {
        await showErrorMessage(response);
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
    const modalInstance = Modal.getInstance(modal);
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
    const modalInstance = Modal.getInstance(modal);
    modalInstance.hide();

    const id = /* ??? */ null;
    const formData = new FormData(this);
    const lesson = {
        title: formData.get('title'),
        description: formData.get('description')
    };

    await LessonService.update(lesson, id);
}