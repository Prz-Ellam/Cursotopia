import $ from 'jquery';
import 'jquery-validation';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

export default {
    rules: {
        'title': {
            required: true,
            trimming: true,
            maxlength: 255
        },
        'description': {
            required: true,
            trimming: true,
            maxlength: 255
        }
    },
    messages: {
        'title': {
            required: 'El título es requerido',
            trimming: 'El título es requerido',
            maxlength: 'El nombre no puede contener más de 255 caracteres'
        },
        'description': {
            required: 'La descripción es requerida',
            trimming: 'La descripción es requerida',
            maxlength: 'La descripción no puede contener más de 255 caracteres'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        let targetElement = element;
        if (element.attr('name') === 'price') {
            targetElement = element.parent();
        }
        error.insertAfter(targetElement).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}