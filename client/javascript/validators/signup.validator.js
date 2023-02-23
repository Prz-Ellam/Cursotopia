import $ from 'jquery';

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
    let pattern=/([°|¬!"#$%&/()=?¡'¿¨*\]´+}~`{[^;:_,.\-<>@\\])/;
    return this.optional(element) || pattern.test(value);
}, 'Please enter a special character');


$('#password').on('input', function() {

    let value = $(this).val();

    if (value === '') {
        //$('.password-minus').removeClass('text-danger text-success');
        $('#password-mayus').removeClass('text-danger text-success');
        $('#password-number').removeClass('text-danger text-success');
        $('#password-specialchar').removeClass('text-danger text-success');
        $('#password-length').removeClass('text-danger text-success');
        return;
    }

    // if (/[a-z]/g.test(value)) {
    //     $('.pwd-lowercase').addClass('text-success').removeClass('text-danger');
    // }
    // else {
    //     $('.pwd-lowercase').addClass('text-danger').removeClass('text-success')
    // }

    if (/[A-Z]/g.test(value)) {
        $('#password-mayus').addClass('text-success').removeClass('text-danger');
    }
    else {
        $('#password-mayus').addClass('text-danger').removeClass('text-success')
    }

    if (/[0-9]/g.test(value)) {
        $('#password-number').addClass('text-success').removeClass('text-danger');
    }
    else {
        $('#password-number').addClass('text-danger').removeClass('text-success')
    }

    if (/[¡”"#$%&;/=’¿?!:;,.\-_+*{}\[\]]/g.test(value)) {
        $('#password-specialchar').addClass('text-success').removeClass('text-danger');
    }
    else {
        $('#password-specialchar').addClass('text-danger').removeClass('text-success')
    }

    if (value.length >= 8) {
        $('#password-length').addClass('text-success').removeClass('text-danger');
    }
    else {
        $('#password-length').addClass('text-danger').removeClass('text-success');
    }

});

let date = new Date();
let dateFormat = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');

export default {
    rules: {
        'profile-picture': {
            required: true
        },
        'name': {
            required: true,
            trimming: true,
            regex: /^[a-zA-Z \u00C0-\u00FF]+$/,
            maxlength: 255
        },
        'last-name': {
            required: true,
            trimming: true,
            regex: /^[a-zA-Z \u00C0-\u00FF]+$/,
            maxlength: 255
        },
        'user-role': {
            required: true,
            range: [ 1, 2]
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
        },
        'password': {
            required: true,
            trimming: true,
            containsMayus: true,
            containsSpecialCharacter: true,
            containsNumber: true,
            minlength:8,
            maxlength: 255
        },
        'confirm-password': {
            required: true,
            trimming: true,
            maxlength: 255,
            equalTo: '#password'
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
            regex: 'El nombre no tiene el formato requerido',
            maxlength: 'El nombre es demasiado largo'
        },
        'user-role': {
            required: 'El rol de usuario es requerido'
        },
        'email': {
            required: 'El correo electrónico es requerido',
            email5322: 'El correo electrónico no tiene el formato correcto',
            maxlength: 'El correo electrónico es demasiado largo'
        },
        'password': {
            required: 'La contraseña es requerida',
            trimming: 'La contraseña es requerida',
            maxlength: 'La contraseña es demasiado larga'
        },
        'confirm-password': {
            required: 'La confirmación de contraseña es requerido',
            trimming: 'La confirmación de contraseña es requerida',
            maxlength: 'La confirmación de contraseña es demasiado larga'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    },
    ignore: []
};