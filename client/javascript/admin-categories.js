import $ from './jquery-global';
import 'jquery-validation';
import CategoryUpdateValidator from './validators/category-update.validator';
import { updateCategory, approveCategory, denyCategory, activateCategory, deactivateCategory, showCategoryDetails} from './controllers/category.controller';

$(async () => {
    $('#update-category-form').validate(CategoryUpdateValidator);
    $('#update-category-form').on('submit', updateCategory);
    
    $(document).on('click', '.update-category-btn', function() {
        const categoryId = $(this).attr('id');
        const modal = document.getElementById('update-category-modal');
        const modalInstance = new bootstrap.Modal(modal);
        showCategoryDetails(categoryId);
        modalInstance.show();
        $('#update-category-form').validate();
    });
    
    $(document).on('click', '.approve-btn', function() {
        const categoryId = $(this).attr('id');
        approveCategory(categoryId);
    });
    
    $(document).on('click', '.denied-btn', function() {
        const categoryId = $(this).attr('id');
        denyCategory(categoryId);
    });

    $(document).on('click', '.activate-btn', function() {
        const categoryId = $(this).attr('id');
        activateCategory(categoryId);
    });

    $(document).on('click', '.deactivate-btn', function() {
        const categoryId = $(this).attr('id');
        deactivateCategory(categoryId);
    });
});
