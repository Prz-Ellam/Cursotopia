import $ from './jquery-global';
import 'jquery-validation';
import categoryValidator from './validators/create-category.validator';

$('#edit-category').validate(categoryValidator);