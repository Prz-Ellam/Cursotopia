import $ from 'jquery';
import 'jquery-validation';
import { passwordToggle, submitLogin } from './controllers/user.controller';
import loginValidator from './validators/login.validator';

$(() => {
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });

    // Esconder y mostrar contraseña
    $('#password-button').on('click', () => {
        passwordToggle('#password', '#password-button i');
    });

    $('#login-form').validate(loginValidator);
    $('#login-form').on('submit', submitLogin);
});
