import $ from 'jquery';
import 'jquery-validation';
import { signup, uploadProfilePicture } from './controllers/user.controller';
import signupValidator from './validators/signup.validator';

const birthDate = document.getElementById('birth-date');
birthDate.value = '2022-10-26';

const profilePicture = document.getElementById('profile-picture');
const signupForm = document.getElementById('signup-form');

profilePicture.addEventListener('change', uploadProfilePicture);
$(signupForm).validate(signupValidator);
signupForm.addEventListener('submit', signup);