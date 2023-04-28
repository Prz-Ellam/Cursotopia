import $ from 'jquery';
import 'jquery-validation';
import { signup, uploadProfilePicture } from './controllers/user.controller';
import { passwordToggle } from './utilities/password-toggle';
import signupValidator from './validators/signup.validator';

$(() => {
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });
    
    // Signup
    $('#signup-form').validate(signupValidator);
    $('#signup-form').on('submit', signup);

    // Profile Picture
    $('#profile-picture').on('change', uploadProfilePicture);

    // Password button
    $('#password-button').on('click', passwordToggle);
    $('#confirm-password-button').on('click', passwordToggle);
});
