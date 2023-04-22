import Swal from "sweetalert2";
import LessonService, { createLessonService } from "../services/lesson.service";
import { Toast } from "../utilities/toast";
import LessonView from "../views/lesson.view";

export const createLesson = async function(event) {
    event.preventDefault();
    
    const validations = $(this).valid();
    if (!validations) {
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
        videoId: Number.parseInt(formData.get('video')),
        imageId: Number.parseInt(formData.get('image')),
        documentId: Number.parseInt(formData.get('document')),
        linkId: Number.parseInt(formData.get('link'))
    }
    
    const response = await LessonService.create(lesson);
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
    
    const validations = $(this).valid();
    if (!validations) {
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
    
    const validations = $(this).valid();
    if (!validations) {
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