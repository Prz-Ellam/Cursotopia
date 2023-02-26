import $ from 'jquery';
import 'jquery-validation';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

$.validator.addMethod("dateRange", function (value, element, parameter) {
    return this.optional(element) ||
        !(Date.parse(value) > Date.parse(parameter[1]) || Date.parse(value) < Date.parse(parameter[0]));
}, 'Please enter a valid date');

$.validator.addMethod('regex', function (value, element, parameter) {
    var regexp = new RegExp(parameter);
    return this.optional(element) || regexp.test(value);
}, 'Please enter a valid input');

$.validator.addMethod('range', function(value, element, parameter) {
    return this.optional(element) || value >= parameter[0] && value <= parameter[1];
});

$.validator.addMethod('email5322', function (value, element) {
    return this.optional(element) || /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(value);
}, 'Please enter a valid email');

const date = new Date();
const dateFormat = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');

export default {
    rules: {
        'profile-picture': {
            required: true
        },
        'name': {
            required: true,
            trimming: true,
            regex: /^[a-zA-Z \u00C0-\u00FF]+$/,
            maxlength:255
        },
        'last-name': {
            required: true,
            trimming: true,
            regex: /^[a-zA-Z \u00C0-\u00FF]+$/,
            maxlength:255
        },
        'gender': {
            required: true,
            range: [ 1, 3 ]
        },
        'birth-date': {
            required: true,
            date: true,
            dateRange: [ '1900-01-01', dateFormat ]
        },
        'email': {
            required: true,
            email: false,
            email5322: true,
            trimming: true,
            maxlength: 255
        }
    },
    messages: {
        'profile-picture': {
            required: 'La foto de perfil es requerida'
        },
        'name': {
            required: 'El nombre es requerido',
            trimming: 'El nombre es requerido',
            regex: 'El nombre no tiene el formato requerido',
            maxlength: 'El nombre es demasiado largo'
        },
        'last-name': {
            required: 'El apellido es requerido',
            trimming: 'El apellido es requerido',
            regex: 'El nombre no tiene el formato requerido',
            maxlength: 'El nombre es demasiado largo'
        },
        'gender': {
            required: 'El genero es requerido',
            range: 'El genero es requerido'
        },
        'birth-date': {
            required: 'La fecha de nacimiento es requerida',
            date: 'La fecha de nacimiento no tiene el formato requerido',
            dateRange: 'La fecha de nacimiento seleccionada no es válida'
        },
        'email': {
            required: 'El correo electrónico es requerido',
            trimming: 'El correo electrónico es requerido',
            email5322: 'El correo electrónico no tiene el formato requerido',
            maxlength: 'El correo electrónico es demasiado largo'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    },
    ignore: []
}; 

