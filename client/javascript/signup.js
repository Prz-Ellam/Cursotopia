import $ from 'jquery';
import 'jquery-validation';
import { signup, uploadProfilePicture } from './controllers/user.controller';
import signupValidator from './validators/signup.validator';

const birthDate = document.getElementById('birth-date');
birthDate.value = '2022-10-26';

const profilePicture = document.getElementById('profile-picture');
const signupForm = document.getElementById('signup-form');

const passwordButton = document.getElementById('password-button');
const confirmPasswordButton = document.getElementById('confirm-password-button');

passwordButton.addEventListener('click', function() {
    this.children[0].classList.toggle('fa-eye');
    const password = document.getElementById('password');
    password.type = (password.type === 'password') ? 'text' : 'password';
});

confirmPasswordButton.addEventListener('click', function() {
    this.children[0].classList.toggle('fa-eye');
    const confirmPassword = document.getElementById('confirm-password');
    confirmPassword.type = (confirmPassword.type === 'password') ? 'text' : 'password';
});

profilePicture.addEventListener('change', uploadProfilePicture);
$(signupForm).validate(signupValidator);
signupForm.addEventListener('submit', signup);