import $ from 'jquery';
import 'jquery-validation';
import LevelView, { courseCreationCreateLevelSection } from '../views/level.view';
import LevelService, { createLevelService } from '../services/level.service';
import { createVideoService } from '../services/video.service';
import { createDocumentService } from '../services/document.service';
import { createImage } from '../services/image.service';
import { Toast } from '../utilities/toast';
import { showErrorMessage } from '../utilities/show-error-message';
import { hideModal } from '../utilities/modal';

export const submitLevelCreate = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    const checkbox = document.getElementById('level-create-free');
    const formData = new FormData(this);
    const level = {
        title:          formData.get('title'),
        description:    formData.get('description'),
        free:           Boolean(checkbox.checked),
        courseId:       Number.parseInt(formData.get('courseId'))
    };

    $('#create-level-btn').prop('disabled', true);
    $('#create-level-spinner').removeClass('d-none');

    const response = await LevelService.create(level);

    $('#create-level-spinner').addClass('d-none');
    $('#create-level-btn').prop('disabled', false);

    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    hideModal('#level-create-modal');

    Toast.fire({
        icon: 'success',
        title: 'El nivel ha sido añadido con éxito'
    });

    LevelView.createLevelSection({ 
        id: response.id,
        title: level.title
    });

    document.querySelector('#level-create-form').reset();
}

export const courseEditionCreateLevel = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    hideModal('#level-create-modal');

    const checkbox = document.getElementById('level-update-free');
    const level = {};
    const response = await createLevelService(level);
/*
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
*/
    courseCreationCreateLevelSection({ 
        id: response.id,
        title: document.getElementById('create-level-title').value
    });
}

export const courseCreationUpdateLevel = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    const checkbox = document.getElementById('level-update-free');
    const formData = new FormData(this);
    const level = {
        title: formData.get('title'),
        description: formData.get('description'),
        free: Boolean(checkbox.checked),
    };

    const id = $('#level-update-id').val();

    $('#update-level-btn').prop('disabled', true);
    $('#update-level-spinner').removeClass('d-none');

    const response = await LevelService.update(level, id);

    $('#update-level-spinner').addClass('d-none');
    $('#update-level-btn').prop('disabled', false);

    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    hideModal('#level-update-modal');

    Toast.fire({
        icon: 'success',
        title: 'El nivel ha sido actualizado con éxito'
    });

    LevelView.updateLevelSection({ 
        id,
        title: level.title
    });

    document.querySelector('#update-level-form').reset();
}

export const courseEditionUpdateLevel = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    hideModal('#level-update-modal');
}

export const createLevelVideo = async function(event) {
    const file = this.files[0];

    const formData = new FormData();
    formData.append('video', file, file.name);

    const response = await createVideoService(formData);
    //const videoHidden = document.getElementById('create-lesson-video-hidden');
    //videoHidden.value = response.id;
}

export const createLevelImage = async function(event) {
    const file = this.files[0];

    const formData = new FormData();
    formData.append('image', file, file.name);

    const response = await createImage(formData);
}

export const createLevelPdf = async function(event) {
    const file = this.files[0];

    const formData = new FormData();
    formData.append('pdf', file, file.name);

    const response = await createDocumentService(formData);
}