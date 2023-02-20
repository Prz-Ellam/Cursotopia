import $ from 'jquery';

$.validator.addMethod('regex', function (value, element, parameter) {
    var regexp = new RegExp(parameter);
    return this.optional(element) || regexp.test(value);
}, 'Please enter a valid input');

export default {
    rules: {
        'name': {
            required: true,
            regex: /^[a-zA-Z \u00C0-\u00FF]+$/,
            maxlength: 255
        },
        'last-name': {
            required: true,
            regex: /^[a-zA-Z \u00C0-\u00FF]+$/,
            maxlength: 255
        },
        'user-role': {
            required: true
        },
        'email': {
            required: true,
            maxlength: 255
        },
        'password': {
            required: true,
            maxlength: 255
        },
        'confirm-password': {
            required: true,
            maxlength: 255
        }
    },
    messages: {
        'name': {
            required: 'El nombre es requerido',
            regex: 'El nombre no tiene el formato requerido',
            maxlength: 'El nombre es demasiado largo'
        },
        'last-name': {
            required: 'El apellido es requerido',
            regex: 'El nombre no tiene el formato requerido',
            maxlength: 'El nombre es demasiado largo'
        },
        'user-role': {
            required: 'El rol de usuario es requerido'
        },
        'email': {
            required: 'El correo electrónico es requerido',
            maxlength: 'El correo electrónico es demasiado largo'
        },
        'password': {
            required: 'La contraseña es requerida',
            maxlength: 'La contraseña es demasiado larga'
        },
        'confirm-password': {
            required: 'La confirmación de contraseña es requerido',
            maxlength: 'La confirmación de contraseña es demasiado larga'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
};