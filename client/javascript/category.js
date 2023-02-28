import $ from 'jquery';
import 'jquery-validation';
import categoryValidator from './validators/create-category.validator';

$('#add-category').validate(categoryValidator);