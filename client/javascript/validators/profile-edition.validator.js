import $ from 'jquery';
import 'jquery-validation';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

$.validator.addMethod('dateMax', function(value, element, parameter) {
    return this.optional(element) || value <= parameter;
}, 'Please enter a valid');

$.validator.addMethod('dateMin', function(value, element, parameter) {
    return this.optional(element) || value >= parameter;
}, 'Please enter a valid');

$.validator.addMethod('regex', function (value, element, parameter) {
    var regexp = new RegExp(parameter);
    return this.optional(element) || regexp.test(value);
}, 'Please enter a valid input');

$.validator.addMethod('range', function(value, element, parameter) {
    return this.optional(element) || value >= parameter[0] && value <= parameter[1];
});

$.validator.addMethod('enum', function(value, element, parameter) {
    return this.optional(element) || parameter.includes(value);
});

$.validator.addMethod('email5322', function (value, element) {
    return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value);
}, 'Please enter a valid email');

const date = new Date();
const year = date.getFullYear() - 18;
const month = String(date.getMonth() + 1).padStart(2, '0');
const day = String(date.getDate()).padStart(2, '0');
const dateFormat = `${year}-${month}-${day}`;

export default {
    rules: {
        'profilePicture': {
            required: true,
            number: true
        },
        'name': {
            required: true,
            trimming: true,
            regex: /^[a-zA-Z \u00C0-\u00FF]+$/,
            maxlength: 50
        },
        'lastName': {
            required: true,
            trimming: true,
            regex: /^[a-zA-Z \u00C0-\u00FF]+$/,
            maxlength: 50
        },
        'gender': {
            required: true,
            enum: [ 'Masculino', 'Femenino', 'Otro' ]
        },
        'birthDate': {
            required: true,
            date: true,
            dateMin: '1900-01-01',
            dateMax: dateFormat,
        },
        'email': {
            required: true,
            email: false,
            email5322: true,
            trimming: true,
            maxlength: 255,
            remote: {
                type: 'POST',
                url: '/api/v1/users/email',
                data: {
                    'email': function () { return $('#email').val() }
                },
                dataType: 'json'
            }
        }
    },
    messages: {
        'profilePicture': {
            required: 'La foto de perfil es requerida',
            number: 'La foto de perfil no es válida'
        },
        'name': {
            required: 'El nombre es requerido',
            trimming: 'El nombre es requerido',
            regex: 'El nombre no tiene el formato requerido',
            maxlength: 'El nombre es demasiado largo'
        },
        'lastName': {
            required: 'El apellido es requerido',
            trimming: 'El apellido es requerido',
            regex: 'El nombre no tiene el formato requerido',
            maxlength: 'El nombre es demasiado largo'
        },
        'gender': {
            required: 'El genero es requerido',
            enum: 'El genero no es válido'
        },
        'birthDate': {
            required: 'La fecha de nacimiento es requerida',
            date: 'La fecha de nacimiento no tiene el formato requerido',
            dateMin: 'La fecha de nacimiento no es válida',
            dateMax: 'Debes tener al menos 18 años para registrarte',
        },
        'email': {
            required: 'El correo electrónico es requerido',
            trimming: 'El correo electrónico es requerido',
            email5322: 'El correo electrónico no tiene el formato requerido',
            maxlength: 'El correo electrónico es demasiado largo',
            remote: 'El correo electrónico esta siendo utilizado por alguien más'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    },
    ignore: []
}; 
