import $ from 'jquery';
import 'jquery-validation';
import CategoryService, { createCategory } from '../services/category.service';
import { Toast } from '../utilities/toast';

export const createCourseCreateCategory = async function(event) {
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