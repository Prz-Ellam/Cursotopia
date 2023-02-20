import $ from 'jquery';
import 'jquery-validation';
import categoryValidator from './validators/categoryValidator';

$('#add-category').validate(categoryValidator);