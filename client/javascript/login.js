import $ from 'jquery';
import 'jquery-validation';
import { login } from './controllers/user.controller';
import loginValidator from './validators/login.validator';

document.addEventListener('DOMContentLoaded', () => {

    const passwordButton = document.getElementById('password-button');
    passwordButton.addEventListener('click', function() {
        this.children[0].classList.toggle('fa-eye');
        const password = document.getElementById('password');
        password.type = (password.type === 'password') ? 'text' : 'password';
    });

    $('#login-form').validate(loginValidator);
    $('#login-form').on('submit', login);
});
