import $ from 'jquery';
import 'jquery-validation';
import { updatePassword } from './controllers/user.controller';
import { passwordToggle } from './utilities/password-toggle';
import passwordEditionValidator from './validators/password-edition.validator';

$(() => {
    $('#password-edition-form').validate(passwordEditionValidator);
    $('#password-edition-form').on('submit', updatePassword);

    $('#old-password-button').on('click', passwordToggle);
    $('#new-password-button').on('click', passwordToggle);
    $('#confirm-new-password-button').on('click', passwordToggle);
});