import { courseCreationCreateLessonSection } from "../views/lesson.view";

export const createLesson = async function(event) {
    event.preventDefault();
    
    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const modal = document.getElementById('create-lesson-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();
    
    const levelId = document.getElementById('create-lesson-level').value;
    const title = document.getElementById('create-lesson-title').value;
    const video = document.getElementById('create-lesson-video').value;
    const image = document.getElementById('create-lesson-image').value;
    const pdf = document.getElementById('create-lesson-pdf').value;

    courseCreationCreateLessonSection({ level: levelId, title, video });

    const createLessonForm = document.getElementById('create-lesson-form');
    createLessonForm.reset();
}

export const courseEditionCreateLesson = async function(event) {
    event.preventDefault();
    
    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const modal = document.getElementById('create-lesson-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();
    
    const levelId = document.getElementById('create-lesson-level').value;
    const title = document.getElementById('create-lesson-title').value;
    const video = document.getElementById('create-lesson-video').value;
    const image = document.getElementById('create-lesson-image').value;
    const pdf = document.getElementById('create-lesson-pdf').value;

    courseCreationCreateLessonSection({ level: levelId, title, video });

    const createLessonForm = document.getElementById('create-lesson-form');
    createLessonForm.reset();
}

export const updateLesson = async function(event) {
    
}