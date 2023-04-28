import $ from 'jquery';
import 'jquery-validation';
import { submitLogin } from './controllers/user.controller';
import { passwordToggle } from './utilities/password-toggle';
import loginValidator from './validators/login.validator';

$(() => {
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });

    $('#login-form').validate(loginValidator);
    $('#login-form').on('submit', submitLogin);

    $('#password-button').on('click', passwordToggle);
});
