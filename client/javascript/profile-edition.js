import $ from 'jquery';
import 'jquery-validation';
import { changeProfilePicture, updateUser } from './controllers/user.controller';
import editProfileValidator from './validators/edit-profile.validator';

$(() => {
    $('#profile-picture').on('change', changeProfilePicture);

    $('#profile-edition-form').validate(editProfileValidator);
    $('#profile-edition-form').validate().element('#email');
    $('#profile-edition-form').on('submit', updateUser);
});
