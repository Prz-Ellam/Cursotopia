import $ from 'jquery';
import 'jquery-validation';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

export default {
    rules: {
        'image': {
            required: true
        },
        'title': {
            required: true,
            trimming: true,
            maxlength: 50
        },
        'description': {
            required: true,
            trimming: true,
            maxlength: 255
        },
        'categories[]': {
            required: true
        },
        'price': {
            required: true,
            number: true,
            min: 0.01,
            max: 10000.00
        }
    },
    messages: {
        'image': {
            required: 'La portada del curso es requerida'
        },
        'title': {
            required: 'El nombre del curso es requerido',
            trimming: 'El nombre del curso es requerido',
            maxlength:'El nombre del curso no puede contener más de 50 caracteres'
        },
        'description': {
            required: 'La descripción del curso es requerido',
            trimming: 'La descripción del curso es requerido',
            maxlength:'La descripción del curso no puede contener más de 255 caracteres'
        },
        'categories[]': {
            required: 'La categoria es requerida'
        },
        'price': {
            required: 'El precio es requerido',
            number: 'El precio no es válido',
            min: 'El precio del producto no puede ser menor o igual a 0',
            max: 'El precio del producto es muy elevado'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        let targetElement = element;
        if (element.attr('name') === 'categories[]' || element.attr('name') === 'price') {
            targetElement = element.parent();
        }
        if (element.attr('name') === 'image') {
            targetElement = $('#image-error'); 
        }
        error.insertAfter(targetElement).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    },
    ignore: []
};