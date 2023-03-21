import $ from 'jquery';
import 'jquery-validation';
import { signup, uploadProfilePicture } from './controllers/user.controller';
import { passwordToggle } from './utilities/password-toggle';
import signupValidator from './validators/signup.validator';

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 1000,
        easing: "ease-in-out",
        once: true,
        mirror: false
    });
    
    // Signup
    const signupForm = document.getElementById('signup-form');
    $(signupForm).validate(signupValidator);
    signupForm.addEventListener('submit', signup);

    // Profile Picture
    const profilePicture = document.getElementById('profile-picture');
    profilePicture.addEventListener('change', uploadProfilePicture);

    // Password button
    const passwordButton = document.getElementById('password-button');
    passwordButton.addEventListener('click', passwordToggle);
    const confirmPasswordButton = document.getElementById('confirm-password-button');
    confirmPasswordButton.addEventListener('click', passwordToggle);
});
