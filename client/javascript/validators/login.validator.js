import $ from 'jquery';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

$.validator.addMethod('email5322', function (value, element) {
    return this.optional(element) || /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(value);
}, 'Please enter a valid email');

export default {
    rules: {
        'email': {
            required: true,
            trimming: true,
            email5322: true,
            email: false,
            maxlength: 255
        },
        'password': {
            required: true,
            trimming: true,
            maxlength: 255
        }
    },
    messages: {
        'email': {
            required: 'El correo electrónico es requerido',
            trimming: 'El correo electrónico es requerido',
            email5322: 'El correo electrónico no tiene el formato correcto',
            maxlength: 'El correo electrónico es demasiado largo'
        },
        'password': {
            required: 'La contraseña es requerida',
            trimming: 'La contraseña es requerida',
            maxlength: 'La contraseña es demasiado larga'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        let targetElement = element;
        if (element.attr('id') === 'password') {
            targetElement = element.parent();
        }
        error.insertAfter(targetElement).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}