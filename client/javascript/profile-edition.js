import $ from 'jquery';
import 'jquery-validation';
import 'bootstrap';
import { changeProfilePicture, submitUpdateUser } from './controllers/user.controller';
import ProfileEditionValidator from './validators/profile-edition.validator';

$(async () => {
    $('#profile-picture').on('change', changeProfilePicture);

    $('#profile-edition-form').validate(ProfileEditionValidator);
    $('#profile-edition-form').validate().element('#email');
    $('#profile-edition-form').on('submit', submitUpdateUser);
});
