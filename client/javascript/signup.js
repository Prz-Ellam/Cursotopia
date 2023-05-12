import $ from 'jquery';
import 'jquery-validation';
import AOS from 'aos';
import { passwordStrength, passwordToggle, submitSignup } from './controllers/user.controller';
import SignupValidator from './validators/signup.validator';
import { displayImageFile } from './controllers/image.controller';

$(async () => {
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });

    $('#password').on('input', () => {
        passwordStrength('#password', '#password-mayus', '#password-number', '#password-specialchar', '#password-length');
    });
    
    // Esconder y mostrar contraseña
    $('#password-button').on('click', () => {
        passwordToggle('#password', '#password-button i');
    });

    $('#confirm-password-button').on('click', () => {
        passwordToggle('#confirm-password', '#confirm-password-button i');
    });

    // Profile Picture
    $('#profile-picture').on('change', async (event) => {
        await displayImageFile(event, '#profile-picture', '#picture-box', PROFILE_PICTURE);
    });
    
    // Signup
    $('#signup-form').validate(SignupValidator);
    $('#signup-form').on('submit', submitSignup);
});
