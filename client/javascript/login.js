import $ from 'jquery';
import 'jquery-validation';
import { login } from './controllers/user.controller';
import loginValidator from './validators/login.validator';

document.addEventListener('DOMContentLoaded', () => {
    $('#login-form').validate(loginValidator);
    $('#login-form').on('submit', login);
});
