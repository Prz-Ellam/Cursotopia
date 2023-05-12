import $ from 'jquery';
import 'bootstrap';
import 'jquery-validation';
import { passwordStrength, passwordToggle, updatePassword } from './controllers/user.controller';
import PasswordEditionValidator from './validators/password-edition.validator';

$(async () => {
    $('#new-password').on('input', function() {
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

    $('#password-edition-form').validate(PasswordEditionValidator);
    $('#password-edition-form').on('submit', updatePassword);
});