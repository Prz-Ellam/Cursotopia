import $ from './jquery-global';
import 'jquery-validation';
import categoryValidator from './validators/create-category.validator';
import { updateCategory, approveCategory, denyCategory, activateCategory, deactivateCategory, showCategoryDetails} from './controllers/category.controller';
import { Toast } from './utilities/toast';
import { approveCategoryService } from './services/category.service';

$(() => {
    $(document).on('click', '.update-category-btn', function() {
        const categoryId = $(this).attr('id');
        const modal = document.getElementById('update-category-modal');
        const modalInstance = new bootstrap.Modal(modal);
        showCategoryDetails(categoryId);
        modalInstance.show();
    });
    
    $('#update-category-form').validate(categoryValidator);
    $('#update-category-form').on('submit', updateCategory); 
    
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
