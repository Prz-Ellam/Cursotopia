import $ from './jquery-global';
import 'jquery-validation';
import categoryValidator from './validators/create-category.validator';
import { updateCategory } from './controllers/category.controller';
import { Toast } from './utilities/toast';

$(document).on('click', '.update-category-btn', function() {
    const modal = document.getElementById('update-category-modal');
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
});

const updateCategoryForm = document.getElementById('update-category-form');
$('#update-category-form').validate(categoryValidator);
updateCategoryForm.addEventListener('submit', updateCategory);

$(document).on('click', '.approve-btn', function() {
    Toast.fire({
        icon: 'success',
        title: 'La categoría ha sido aprobada'
    });
});

$(document).on('click', '.denied-btn', function() {
    Toast.fire({
        icon: 'error',
        title: 'La categoría ha sido rechazada'
    });
});