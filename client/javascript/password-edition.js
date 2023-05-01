import $ from 'jquery';
import 'jquery-validation';
import { passwordStrength, passwordToggle, updatePassword } from './controllers/user.controller';
import passwordEditionValidator from './validators/password-edition.validator';

$(() => {
    $('#new-password').on('input', function(event) {
        passwordStrength('#new-password', '#password-mayus', '#password-number', '#password-specialchar', '#password-length');
    });

    // Esconder y mostrar contraseña
    $('#old-password-button').on('click', function() {
        passwordToggle('#old-password', '#old-password-button i');
    });

    $('#new-password-button').on('click', function() {
        passwordToggle('#new-password', '#new-password-button i');
    });

    $('#confirm-new-password-button').on('click', function() {
        passwordToggle('#confirm-new-password', '#confirm-new-password-button i');
    });

    $('#password-edition-form').validate(passwordEditionValidator);
    $('#password-edition-form').on('submit', updatePassword);
});