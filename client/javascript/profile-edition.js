import $ from 'jquery';
import 'jquery-validation';
import { updateUser, uploadProfilePicture } from './controllers/user.controller';
import editProfileValidator from './validators/edit-profile.validator';

document.addEventListener('DOMContentLoaded', () => {   
    const profileEditionForm = document.getElementById('profile-edition-form');
    $(profileEditionForm).validate(editProfileValidator);
    profileEditionForm.addEventListener('submit', updateUser);

    const profilePicture = document.getElementById('profile-picture');
    profilePicture.addEventListener('change', uploadProfilePicture);
});
