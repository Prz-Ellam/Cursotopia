import $ from 'jquery';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

$.validator.addMethod('regex', function (value, element, parameter) {
    var regexp = new RegExp(parameter);
    return this.optional(element) || regexp.test(value);
}, 'Please enter a valid input');

$.validator.addMethod('range', function(value, element, parameter) {
    return this.optional(element) || value >= parameter[0] && value <= parameter[1];
});

$.validator.addMethod('dateMax', function(value, element, parameter) {
    return this.optional(element) || value <= parameter;
}, 'Please enter a valid');

$.validator.addMethod('dateMin', function(value, element, parameter) {
    return this.optional(element) || value >= parameter;
}, 'Please enter a valid');

$.validator.addMethod('enum', function(value, element, parameter) {
    return this.optional(element) || parameter.includes(value);
});

$.validator.addMethod('email5322', function (value, element) {
    return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value);
}, 'Please enter a valid email');

$.validator.addMethod('containsNumber',function(value,element){
    let pattern=/[0-9]/;
    return this.optional(element) || pattern.test(value);
}, 'Please enter a number');

$.validator.addMethod('containsMayus',function(value,element){
    let pattern=/[A-Z]/;
    return this.optional(element) || pattern.test(value);
}, 'Please enter a mayus');

$.validator.addMethod('containsMinus',function(value,element){
    let pattern=/[a-z]/;
    return this.optional(element) || pattern.test(value);
});

$.validator.addMethod('containsSpecialCharacter',function(value,element){
    let pattern=/([°|¬!"#$%&/()=?¡'¿¨*\]´+}~`{[^;:_,.\-<>@])/;
    return this.optional(element) || pattern.test(value);
}, 'Please enter a special character');

const date = new Date();
const year = date.getFullYear() - 18;
const month = String(date.getMonth() + 1).padStart(2, '0');
const day = String(date.getDate()).padStart(2, '0');
const dateFormat = `${year}-${month}-${day}`;

export default {
    rules: {
        'image': {
            required: true
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
        'userRole': {
            required: true,
            range: [ 2, 3 ]
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
                url: 'api/v1/users/email',
                data: {
                    'email': function () { return $('#email').val() }
                },
                dataType: 'json'
            }
        },
        'password': {
            required: true,
            trimming: true,
            containsMayus: true,
            containsSpecialCharacter: true,
            containsNumber: true,
            minlength: 8,
            maxlength: 255
        },
        'confirmPassword': {
            required: true,
            trimming: true,
            maxlength: 255,
            equalTo: '#password'
        }
    },
    messages: {
        'image': {
            required: 'La foto de perfil es requerida'
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
        'userRole': {
            required: 'El rol de usuario es requerido',
            range: 'El rol de usuario es requerido'
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
        },
        'password': {
            required: 'La contraseña es requerida',
            trimming: 'La contraseña es requerida',
            containsMayus: 'La contraseña no tiene el formato requerido',
            containsSpecialCharacter: 'La contraseña no tiene el formato requerido',
            containsNumber: 'La contraseña no tiene el formato requerido',
            minlength: 'La contraseña no tiene el formato requerido',
            maxlength: 'La contraseña es demasiado larga'
        },
        'confirmPassword': {
            required: 'La confirmación de contraseña es requerido',
            trimming: 'La confirmación de contraseña es requerida',
            maxlength: 'La confirmación de contraseña es demasiado larga',
            equalTo: 'La confirmación de contraseña no coincide con la contraseña'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        let targetElement = element;
        if (element.attr('id') === 'password' || element.attr('id') === 'confirm-password'
            || element.attr('id') === 'profile-picture') {
            targetElement = element.parent();
        }
        error.insertAfter(targetElement).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    },
    ignore: []
};




