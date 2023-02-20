import $ from 'jquery';
import 'jquery-validation';
import categoryValidator from './validators/category.validator';

$('#add-category').validate(categoryValidator);