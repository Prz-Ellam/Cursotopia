import $ from 'jquery';
import 'jquery-validation';
import { updatePassword } from './controllers/user.controller';
import passwordEditionValidator from './validators/password-edition.validator';

$('#password-edition-form').validate(passwordEditionValidator);
$('#password-edition-form').on('submit', updatePassword);

const oldasswordButton = document.getElementById('old-password-button');
const newPasswordButton = document.getElementById('new-password-button');
const confirmNewPasswordButton = document.getElementById('confirm-new-password-button');

oldasswordButton.addEventListener('click', function() {
    this.children[0].classList.toggle('fa-eye');
    const password = document.getElementById('old-password');
    password.type = (password.type === 'password') ? 'text' : 'password';
});

newPasswordButton.addEventListener('click', function() {
    this.children[0].classList.toggle('fa-eye');
    const password = document.getElementById('new-password');
    password.type = (password.type === 'password') ? 'text' : 'password';
});

confirmNewPasswordButton.addEventListener('click', function() {
    this.children[0].classList.toggle('fa-eye');
    const confirmPassword = document.getElementById('confirm-new-password');
    confirmPassword.type = (confirmPassword.type === 'password') ? 'text' : 'password';
});