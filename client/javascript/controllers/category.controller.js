import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import CategoryService, {updateCategoryService, createCategory, approveCategoryService, denyCategoryService, activateCategoryService, deactivateCategoryService} from '../services/category.service';
import { showApprovedCategories, showNotApprovedCategories, showNotActiveCategories} from '../views/category.view';
import { Toast } from '../utilities/toast';
import { showErrorMessage } from '../utilities/show-error-message';

export const submitCategory = async function(event) {
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
    
    $('#category-create-btn').prop('disabled', true);
    $('#category-create-spinner').removeClass('d-none');
    const response = await createCategory(category);
    $('#category-create-spinner').addClass('d-none');
    $('#category-create-btn').prop('disabled', false);

    const modal = document.getElementById('category-create-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();

    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    await Swal.fire({
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

    const createCategoryForm = document.getElementById('category-create-form');
    createCategoryForm.reset();
}

export const updateCourseCreateCategory = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const modal = document.getElementById('category-create-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();

    const formData = new FormData(this);
    const category = {
        name: formData.get('name'),
        description: formData.get('description')
    };
    const response = await createCategory(category);
    if (response?.status) {
        Toast.fire({
            icon: 'success',
            title: 'La categoría ha sido añadida con éxito'
        });
    }

    const createCategoryForm = document.getElementById('category-create-form');
    createCategoryForm.reset();
}

export const updateCategory = async function(event) {
    event.preventDefault();
    
    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const modal = document.getElementById('update-category-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();

    const formData = new FormData(this);
    const category = {
        name: formData.get('name'),
        description: formData.get('description'),
        id: formData.get('id')
    };

    console.log(category);

    const response = await updateCategoryService(category);
    console.log(response);
    if (response?.status) {

        Toast.fire({
            icon: 'success',
            title: 'La categoría ha sido actualizada con éxito'
        });

         $('#approvedCategories').empty();
        const approvedCategories = await CategoryService.findApproved();
        if (approvedCategories?.status) {
            const categoriesApproved = approvedCategories.categories;
            categoriesApproved.forEach(category => {
                showApprovedCategories(category);
            });
        }

    }else{
        Toast.fire({
            icon: 'error',
            title: 'La categoría no se pudo actualizar'
        });
    }

}

export const showCategoryDetails = async function(categoryId) {

    const response = await CategoryService.findById(categoryId);
    console.log(response);
    if (response?.status) {
        const category = response.category;
        if(category.active==false){
            $('#category-name').prop('readonly', true);
            $('#category-description').prop('readonly', true);
            $('#save-btn').prop('disabled', true);
        }else{
            $('#category-name').prop('readonly', false);
            $('#category-description').prop('readonly', false);
            $('#save-btn').prop('disabled', false);
        }
        $('#category-id').val(category.id);
        $('#category-name').val(category.name);
        $('#category-description').val(category.description);
        return;
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }
}

export const approveCategory = async function(categoryId) {

    const response = await approveCategoryService(categoryId);
    if (response?.status) {
        $('#notApprovedCategories').empty();
        $('#inactiveCategories').empty();
        $('#approvedCategories').empty();
        const approvedCategories = await CategoryService.findApproved();
        const notApprovedCategories = await CategoryService.findnotApproved();
        const notActiveCategories = await CategoryService.findnotActive();
        if (approvedCategories?.status && notApprovedCategories?.status && notActiveCategories?.status) {
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
        Toast.fire({
            icon: 'success',
            title: 'La categoría ha sido aprobada'
        });
        return;
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }
}

export const denyCategory = async function(categoryId) {
    const response = await denyCategoryService(categoryId);
    if (response?.status) {
        $('#notApprovedCategories').empty();
        $('#inactiveCategories').empty();
        $('#approvedCategories').empty();
        const approvedCategories = await CategoryService.findApproved();
        const notApprovedCategories = await CategoryService.findnotApproved();
        const notActiveCategories = await CategoryService.findnotActive();
        if (approvedCategories?.status && notApprovedCategories?.status && notActiveCategories?.status) {
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
        Toast.fire({
            icon: 'error',
            title: 'La categoría ha sido rechazada'
        });
        return;
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }
}

export const activateCategory = async function(categoryId) {
    const response = await activateCategoryService(categoryId);
    if (response?.status) {
        $('#notApprovedCategories').empty();
        $('#inactiveCategories').empty();
        $('#approvedCategories').empty();
        const approvedCategories = await CategoryService.findApproved();
        const notApprovedCategories = await CategoryService.findnotApproved();
        const notActiveCategories = await CategoryService.findnotActive();
        if (approvedCategories?.status && notApprovedCategories?.status && notActiveCategories?.status) {
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
        Toast.fire({
            icon: 'success',
            title: 'La categoría ha sido activada'
        });
        return;
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }
}

export const deactivateCategory = async function(categoryId) {
    const response = await deactivateCategoryService(categoryId);
    console.log(response);
    if (response?.status) {
        $('#notApprovedCategories').empty();
        $('#inactiveCategories').empty();
        $('#approvedCategories').empty();
        const approvedCategories = await CategoryService.findApproved();
        const notApprovedCategories = await CategoryService.findnotApproved();
        const notActiveCategories = await CategoryService.findnotActive();
        if (approvedCategories?.status && notApprovedCategories?.status && notActiveCategories?.status) {
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
        Toast.fire({
            icon: 'success',
            title: 'La categoría ha sido desactivada'
        });
        return;
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }
}