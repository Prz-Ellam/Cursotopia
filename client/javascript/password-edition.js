import $ from 'jquery';
import 'jquery-validation';
import { updatePassword } from './controllers/user.controller';
import { passwordToggle } from './utilities/password-toggle';
import passwordEditionValidator from './validators/password-edition.validator';

$('#password-edition-form').validate(passwordEditionValidator);
$('#password-edition-form').on('submit', updatePassword);

const oldasswordButton = document.getElementById('old-password-button');
const newPasswordButton = document.getElementById('new-password-button');
const confirmNewPasswordButton = document.getElementById('confirm-new-password-button');

oldasswordButton.addEventListener('click', passwordToggle);
newPasswordButton.addEventListener('click', passwordToggle);
confirmNewPasswordButton.addEventListener('click', passwordToggle);