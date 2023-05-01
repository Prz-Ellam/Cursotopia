import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import CategoryService, { createCategory } from '../services/category.service';
import { Toast } from '../utilities/toast';

export const createCourseCreateCategory = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
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
    }

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

export const updateCategory = function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const modal = document.getElementById('update-category-modal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();

    Toast.fire({
        icon: 'success',
        title: 'La categoría ha sido actualizada con éxito'
    });
}

export const deleteCategory = function(event) {
    event.preventDefault();
}