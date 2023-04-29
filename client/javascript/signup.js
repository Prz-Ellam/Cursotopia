import $ from 'jquery';
import 'jquery-validation';
import { submitSignup, uploadProfilePicture } from './controllers/user.controller';
import { passwordToggle } from './utilities/password-toggle';
import SignupValidator from './validators/signup.validator';

$(() => {
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });

    // Esconder y mostrar contraseña
    $('#password-button').on('click', passwordToggle);
    $('#confirm-password-button').on('click', passwordToggle);

    // Profile Picture
    $('#profile-picture').on('change', uploadProfilePicture);
    
    // Signup
    $('#signup-form').validate(SignupValidator);
    $('#signup-form').on('submit', submitSignup);
});
