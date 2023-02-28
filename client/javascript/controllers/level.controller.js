import $ from 'jquery';
import 'jquery-validation';
import { courseCreationCreateLevelSection } from '../views/level.view';
import { createLevelService } from '../services/level.service';

export const createLevel = async function(event) {
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

}

export const createLevelImage = async function(event) {

}

export const createLevelPdf = async function(event) {
    
}