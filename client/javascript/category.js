import $ from 'jquery';
import 'jquery-validation';
import categoryValidator from './validators/category-create.validator';

$(() => {
    $('#add-category').validate(categoryValidator);
});