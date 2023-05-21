import $ from 'jquery';
import 'jquery-validation';
import LevelView, { courseCreationCreateLevelSection } from '@/views/level.view';
import LevelService from '@/services/level.service';
import { Toast, ToastTopEnd } from '@/utilities/toast';
import { showErrorMessage } from '@/utilities/show-error-message';
import { hideModal } from '@/utilities/modal';

export const submitLevelCreate = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Formulario no válido'
        });
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

    $('#level-create-btn').prop('disabled', true);
    $('#level-create-spinner').removeClass('d-none');

    const response = await LevelService.create(level);

    $('#level-create-spinner').addClass('d-none');
    $('#level-create-btn').prop('disabled', false);

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
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Formulario no válido'
        });
        return;
    }

    hideModal('#level-create-modal');

    const checkbox = document.getElementById('level-update-free');
    const level = {};
    const response = await LevelService.create(level);
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
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Formulario no válido'
        });
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
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Formulario no válido'
        });
        return;
    }

    hideModal('#level-update-modal');
}
