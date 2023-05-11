import $ from 'jquery';
import 'jquery-validation';
import { passwordToggle, submitLogin } from './controllers/user.controller';
import LoginValidator from './validators/login.validator';

$(async () => {
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

    $('#login-form').validate(LoginValidator);
    $('#login-form').on('submit', submitLogin);
});
