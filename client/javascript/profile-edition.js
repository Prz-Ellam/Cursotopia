import $ from 'jquery';
import 'jquery-validation';
import { updateUser, uploadProfilePicture } from './controllers/user.controller';
import editProfileValidator from './validators/edit-profile.validator';

document.addEventListener('DOMContentLoaded', () => {
    const date = new Date();
    const dateFormat = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
    const birthDate = document.getElementById('birth-date');
    birthDate.value = dateFormat;
    
    const profileEditionForm = document.getElementById('profile-edition-form');
    $(profileEditionForm).validate(editProfileValidator);
    profileEditionForm.addEventListener('submit', updateUser);

    const profilePicture = document.getElementById('profile-picture');
    profilePicture.addEventListener('change', uploadProfilePicture);
});
