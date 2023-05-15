import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import CategoryService, { approveCategoryService, denyCategoryService, activateCategoryService, deactivateCategoryService} from '../services/category.service';
import { showApprovedCategories, showNotApprovedCategories, showNotActiveCategories} from '../views/category.view';
import { Toast, ToastTopEnd } from '../utilities/toast';
import { showErrorMessage } from '../utilities/show-error-message';
import { hideModal } from '../utilities/modal';

export const submitCategory = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Formulario no válido'
        });
        return;
    }

    const formData = new FormData(this);
    const category = {
        name:           formData.get('name'),
        description:    formData.get('description')
    };
    
    $('#category-create-btn').prop('disabled', true);
    $('#category-create-spinner').removeClass('d-none');

    const response = await CategoryService.create(category);

    $('#category-create-spinner').addClass('d-none');
    $('#category-create-btn').prop('disabled', false);

    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    hideModal('#category-create-modal');
    
    Swal.fire({
        icon: 'success',
        title: 'La categoría fue añadida con éxito',
        text: 'La categoría fue añadida, un administrador debe aprobarla primero, podrás usar la categoría para crear cursos pero estos no serán visibles hasta que un administrador apruebe la categoría',
        confirmButtonText: 'Enterado',
        confirmButtonColor: '#5650DE',
        background: '#FFFFFF',
        customClass: {
            confirmButton: 'btn btn-primary shadow-none rounded-pill'
        },
    });

    const categoryResponse = await CategoryService.findAll();
    if (categoryResponse?.status) {
        $('#categories').html('');
        categoryResponse.categories.forEach(category => {
            $('#categories').append(`
                <option value="${category.id}">${category.name}</option>
            `);
        });
        $('#categories').multipleSelect('refresh');
    }

    document.querySelector('#category-create-form').reset();
}

export const updateCourseCreateCategory = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    const formData = new FormData(this);
    const category = {
        name: formData.get('name'),
        description: formData.get('description')
    };
    const response = await CategoryService.create(category);
    
    if (response?.status) {
        Toast.fire({
            icon: 'success',
            title: 'La categoría ha sido añadida con éxito'
        });
    }

    hideModal('#category-create-modal');

    document.querySelector('#category-create-form').reset();
}

export const updateCategory = async function(event) {
    event.preventDefault();
    
    const isFormValid = $(this).valid();
    if (!isFormValid) {
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Formulario no válido'
        });
        return;
    }

    const formData = new FormData(this);
    const id = formData.get('id')
    const category = {
        name: formData.get('name'),
        description: formData.get('description'),
    };

    $('#category-update-btn').prop('disabled', true);
    $('#category-update-spinner').removeClass('d-none');

    const response = await CategoryService.update(id, category);
    
    $('#category-update-spinner').addClass('d-none');
    $('#category-update-btn').prop('disabled', false);

    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    hideModal('#update-category-modal');

    Toast.fire({
        icon: 'success',
        title: 'La categoría ha sido actualizada con éxito'
    });

    const approvedCategories = await CategoryService.findApproved();
    $('#approvedCategories').empty();
    if (approvedCategories?.status) {
        const categoriesApproved = approvedCategories.categories;
        categoriesApproved.forEach(category => {
            showApprovedCategories(category);
        });
    }
}

export const showCategoryDetails = async function(categoryId) {
    const response = await CategoryService.findById(categoryId);
    
    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    
    const { category } = response;
    const readonly = !category.active;
    $('#category-name').prop('readonly', readonly);
    $('#category-description').prop('readonly', readonly);
    $('#save-btn').prop('disabled', readonly);

    $('#category-id').val(category.id);
    $('#category-name').val(category.name);
    $('#category-description').val(category.description);    
}

export const approveCategory = async function(categoryId) {
    const response = await approveCategoryService(categoryId);
    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    const approvedCategories = await CategoryService.findApproved();
    const notApprovedCategories = await CategoryService.findnotApproved();
    const notActiveCategories = await CategoryService.findnotActive();

    if (!approvedCategories?.status || !notApprovedCategories?.status || !notActiveCategories?.status) {
        showErrorMessage({ message: 'Ocurrio un error inesperado' });
        return;
    }

    $('#notApprovedCategories').empty();
    $('#inactiveCategories').empty();
    $('#approvedCategories').empty();

    const categoriesApproved = approvedCategories.categories;
    const categoriesNotApproved = notApprovedCategories.categories;
    const categoriesNotActive = notActiveCategories.categories;

    categoriesApproved.forEach(category => {
        showApprovedCategories(category);
    });

    categoriesNotApproved.forEach(category => {
        showNotApprovedCategories(category);
    });

    categoriesNotActive.forEach(category => {
        showNotActiveCategories(category);
    });

    Toast.fire({
        icon: 'success',
        title: 'La categoría ha sido aprobada'
    });    
}

export const denyCategory = async function(categoryId) {
    const response = await denyCategoryService(categoryId);
    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    const approvedCategories = await CategoryService.findApproved();
    const notApprovedCategories = await CategoryService.findnotApproved();
    const notActiveCategories = await CategoryService.findnotActive();
    if (approvedCategories?.status && notApprovedCategories?.status && notActiveCategories?.status) {
        $('#notApprovedCategories').empty();
        $('#inactiveCategories').empty();
        $('#approvedCategories').empty();
            
        const categoriesApproved = approvedCategories.categories;
        const categoriesNotApproved = notApprovedCategories.categories;
        const categoriesNotActive = notActiveCategories.categories;
        categoriesApproved.forEach(category => {
            showApprovedCategories(category);
        });
        categoriesNotApproved.forEach(category => {
            showNotApprovedCategories(category);
        });
        categoriesNotActive.forEach(category => {
            showNotActiveCategories(category);
        });
    }

    await Toast.fire({
        icon: 'error',
        title: 'La categoría ha sido rechazada'
    });
}

export const activateCategory = async function(categoryId) {
    const response = await activateCategoryService(categoryId);
    if (!response?.status) {
        await showErrorMessage(response);
        return;
    }

    const approvedCategories = await CategoryService.findApproved();
    const notApprovedCategories = await CategoryService.findnotApproved();
    const notActiveCategories = await CategoryService.findnotActive();
    if (approvedCategories?.status && notApprovedCategories?.status && notActiveCategories?.status) {
        $('#notApprovedCategories').empty();
        $('#inactiveCategories').empty();
        $('#approvedCategories').empty();

        const categoriesApproved = approvedCategories.categories;
        const categoriesNotApproved = notApprovedCategories.categories;
        const categoriesNotActive = notActiveCategories.categories;
        categoriesApproved.forEach(category => {
            showApprovedCategories(category);
        });
        categoriesNotApproved.forEach(category => {
            showNotApprovedCategories(category);
        });
        categoriesNotActive.forEach(category => {
            showNotActiveCategories(category);
        });
    }
        
    await Toast.fire({
        icon: 'success',
        title: 'La categoría ha sido activada'
    });
}

export const deactivateCategory = async function(categoryId) {
    const response = await deactivateCategoryService(categoryId);
    if (!response?.status) {
        await showErrorMessage(response);
        return;
    }

    const approvedCategories = await CategoryService.findApproved();
    const notApprovedCategories = await CategoryService.findnotApproved();
    const notActiveCategories = await CategoryService.findnotActive();
    if (approvedCategories?.status && notApprovedCategories?.status && notActiveCategories?.status) {
        $('#notApprovedCategories').empty();
        $('#inactiveCategories').empty();
        $('#approvedCategories').empty();
            
        const categoriesApproved = approvedCategories.categories;
        const categoriesNotApproved = notApprovedCategories.categories;
        const categoriesNotActive = notActiveCategories.categories;
        categoriesApproved.forEach(category => {
            showApprovedCategories(category);
        });
        categoriesNotApproved.forEach(category => {
            showNotApprovedCategories(category);
        });
        categoriesNotActive.forEach(category => {
            showNotActiveCategories(category);
        });
    }

    await Toast.fire({
        icon: 'success',
        title: 'La categoría ha sido desactivada'
    });
}