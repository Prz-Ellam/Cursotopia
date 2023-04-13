import $ from 'jquery';
import 'jquery-validation';
import { courseCreationCreateLevelSection } from '../views/level.view';
import { createLevelService } from '../services/level.service';
import { createVideoService } from '../services/video.service';
import { createDocumentService } from '../services/document.service';
import { createImage } from '../services/image.service';

export const createLevel = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const modal = document.getElementById('create-level-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();

    const formData = new FormData(this);
    const level = {
        title: formData.get('title'),
        description: formData.get('description'),
        price: Number.parseFloat(formData.get('price')),
        courseId: Number.parseInt(formData.get('courseId'))
    };
    const response = await createLevelService(level);

    const levelsList = document.getElementById('levels-list');
    if (levelsList.children.length === 1 && levelsList.children[0].value === '') {
        levelsList.children[0].value = response.id;
    }
    else {
        const levelId = document.createElement('input');
        levelId.setAttribute('type', 'hidden');
        levelId.setAttribute('name', 'levels[]');
        levelId.setAttribute('autocomplete', 'off');
        levelId.value = response.id;
        levelsList.appendChild(levelId);
    }
    courseCreationCreateLevelSection({ 
        id: response.id,
        title: document.getElementById('create-level-title').value
    });
}

export const courseEditionCreateLevel = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const modal = document.getElementById('create-level-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();

    const level = {};
    const response = await createLevelService(level);

    const levelsList = document.getElementById('levels-list');
    if (levelsList.children.length === 1 && levelsList.children[0].value === '') {
        levelsList.children[0].value = response.id;
    }
    else {
        const levelId = document.createElement('input');
        levelId.setAttribute('type', 'hidden');
        levelId.setAttribute('name', 'levels[]');
        levelId.setAttribute('autocomplete', 'off');
        levelId.value = response.id;
        levelsList.appendChild(levelId);
    }
    courseCreationCreateLevelSection({ 
        id: response.id,
        title: document.getElementById('create-level-title').value
    });
}

export const courseCreationUpdateLevel = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const modal = document.getElementById('update-level-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();

    const formData = new FormData(this);
    const level = {
        title: formData.get('title'),
        description: formData.get('description'),
        price: Number.parseFloat(formData.get('price')),
        courseId: Number.parseInt(formData.get('courseId'))
    };
}

export const courseEditionUpdateLevel = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const modal = document.getElementById('update-level-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();
}

export const createLevelVideo = async function(event) {
    const file = this.files[0];

    const formData = new FormData();
    formData.append('video', file, file.name);

    const response = await createVideoService(formData);
    const videoHidden = document.getElementById('create-lesson-video-hidden');
    videoHidden.value = response.id;
}

export const createLevelImage = async function(event) {
    const file = this.files[0];

    const formData = new FormData();
    formData.append('image', file, file.name);

    const response = await createImage(formData);
    const imageHidden = document.getElementById('create-lesson-image-hidden');
    imageHidden.value = response.id;
}

export const createLevelPdf = async function(event) {
    const file = this.files[0];

    const formData = new FormData();
    formData.append('pdf', file, file.name);

    const response = await createDocumentService(formData);
    const pdfHidden = document.getElementById('create-lesson-pdf-hidden');
    pdfHidden.value = response.id;
}