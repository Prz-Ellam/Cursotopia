import $ from './jquery-global';
import 'jquery-validation';
import categoryValidator from './validators/create-category.validator';
import { updateCategory } from './controllers/category.controller';

const updateCategoryForm = document.getElementById('update-category-form');
$('#update-category-form').validate(categoryValidator);
updateCategoryForm.addEventListener('submit', updateCategory);