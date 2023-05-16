import '../assets/images/404.svg';
import '../assets/images/girl-working-on-laptop.svg';
import '../assets/images/hero-banner-background.svg';
import '../assets/images/hero-banner.svg';
import '../assets/images/horizontal-logo.svg';
import '../assets/images/logo.png';
import '../assets/images/online-shopping.png';
import '../assets/images/perfil.png';
import '../assets/images/work-with-the-best.png';

import $ from './jquery-global';
import 'jquery-validation';
import 'bootstrap';
import CategoryUpdateValidator from '@/validators/category-update.validator';
import { approveCategory, denyCategory, showCategoryDetails, submitUpdateCategory} from '@/controllers/category.controller';
import { showModal } from '@/utilities/modal';

$(async () => {
    $('#update-category-form').validate(CategoryUpdateValidator);
    $('#update-category-form').on('submit', submitUpdateCategory);
    
    $(document).on('click', '.update-category-btn', function() {
        const categoryId = $(this).attr('data-id');
        showModal('#update-category-modal');
        showCategoryDetails(categoryId);
        $('#update-category-form').validate();
    });
    
    $(document).on('click', '.approve-btn', async function() {
        const categoryId = $(this).attr('data-id');
        await approveCategory(categoryId);
    });
    
    $(document).on('click', '.denied-btn', async function() {
        const categoryId = $(this).attr('data-id');
        await denyCategory(categoryId);
    });
});
