import $ from 'jquery';
import 'jquery-validation';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

$.validator.addMethod('email5322', function (value, element) {
    return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value);
}, 'Please enter a valid email');

export default {
    rules: {
        'email': {
            required: true,
            trimming: true,
            email5322: true,
            email: false,
            minlength: 1,
            maxlength: 255
        },
        'password': {
            required: true,
            trimming: true,
            minlength: 1,
            maxlength: 255
        }
    },
    messages: {
        'email': {
            required: 'El correo electrónico es requerido',
            trimming: 'El correo electrónico es requerido',
            email5322: 'El correo electrónico no tiene el formato correcto',
            minlength: 'El correo electrónico no puede estar vacío',
            maxlength: 'El correo electrónico es demasiado largo'
        },
        'password': {
            required: 'La contraseña es requerida',
            trimming: 'La contraseña es requerida',
            minlength: 'La contraseña no puede estar vacía',
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
    },
    ignore: []
}