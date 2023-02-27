import $ from 'jquery';
import 'jquery-validation';
import { login } from './controllers/user.controller';
import { passwordToggle } from './utilities/password-toggle';
import loginValidator from './validators/login.validator';

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 1000,
        easing: "ease-in-out",
        once: true,
        mirror: false
    });

    const loginForm = document.getElementById('login-form');
    const passwordButton = document.getElementById('password-button');
    
    passwordButton.addEventListener('click', passwordToggle);
    $(loginForm).validate(loginValidator);
    loginForm.addEventListener('submit', login);
});
