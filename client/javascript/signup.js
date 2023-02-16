import $ from 'jquery';
import 'jquery-validation';
import { signup, uploadProfilePicture } from './controllers/user.controller';
import signupValidator from './validators/signup.validator';

$('#birth-date').val('2022-10-10');

$('#profile-picture').on('change', uploadProfilePicture);
$('#signup-form').validate(signupValidator);
$('#signup-form').on('submit', signup);