import $ from 'jquery';
import 'jquery-validation';
import { changeProfilePicture, updateUser } from './controllers/user.controller';
import editProfileValidator from './validators/edit-profile.validator';

document.addEventListener('DOMContentLoaded', () => {
    const profilePicture = document.getElementById('profile-picture');
    profilePicture.addEventListener('change', changeProfilePicture);

    const profileEditionForm = document.getElementById('profile-edition-form');
    $(profileEditionForm).validate(editProfileValidator);
    $(profileEditionForm).validate().element('#email');
    profileEditionForm.addEventListener('submit', updateUser);
});
