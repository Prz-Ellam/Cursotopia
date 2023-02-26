import $ from 'jquery';
import 'jquery-validation';
import { signup, uploadProfilePicture } from './controllers/user.controller';
import { passwordToggle } from './utilities/password-toggle';
import signupValidator from './validators/signup.validator';

document.addEventListener('DOMContentLoaded', () => {
    const birthDate = document.getElementById('birth-date');
    birthDate.value = '2022-10-26';

    const profilePicture = document.getElementById('profile-picture');
    const signupForm = document.getElementById('signup-form');

    const passwordButton = document.getElementById('password-button');
    const confirmPasswordButton = document.getElementById('confirm-password-button');

    passwordButton.addEventListener('click', passwordToggle);
    confirmPasswordButton.addEventListener('click', passwordToggle);

    profilePicture.addEventListener('change', uploadProfilePicture);
    $(signupForm).validate(signupValidator);
    signupForm.addEventListener('submit', signup);
});
