import $ from 'jquery';
import 'jquery-validation';

$.validator.addMethod('notEqualTo', function(value, element, parameter) {
    const htmlElement = document.querySelector(parameter);
    return this.optional(element) || htmlElement.value !== value;
}, 'Please enter a valid');

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

$.validator.addMethod('containsNumber',function(value,element){
    const pattern=/[0-9]/;
    return this.optional(element) || pattern.test(value);
}, 'Please enter a number');

$.validator.addMethod('containsMayus',function(value,element){
    const pattern=/[A-Z]/;
    return this.optional(element) || pattern.test(value);
}, 'Please enter a mayus');

$.validator.addMethod('containsMinus',function(value,element){
    const pattern=/[a-z]/;
    return this.optional(element) || pattern.test(value);
});

$.validator.addMethod('containsSpecialCharacter',function(value,element){
    const pattern=/([°|¬!"#$%&/()=?¡'¿¨*\]´+}~`{[^;:_,.\-<>@\\])/;
    return this.optional(element) || pattern.test(value);
}, 'Please enter a special character');

export default {
    rules: {
        'oldPassword': {
            required: true,
            trimming: true,
            maxlength: 255
        },
        'newPassword': {
            required: true,
            trimming: true,
            containsMayus: true,
            containsSpecialCharacter: true,
            containsNumber: true,
            minlength:8,
            maxlength: 255,
            notEqualTo: '#old-password'
        },
        'confirmNewPassword': {
            required: true,
            trimming: true,
            maxlength: 255,
            equalTo: '#new-password'
        }
    },
    messages: {
        'oldPassword': {
            required: 'La antigua contraseña es requerida',
            trimming: 'La antigua contraseña es requerida',
            maxlength: 'La antigua contraseña es demasiado larga'
        },
        'newPassword': {
            required: 'La nueva contraseña es requerida',
            trimming: 'La nueva contraseña es requerida',
            containsMayus: 'La contraseña no tiene el formato requerido',
            containsSpecialCharacter: 'La contraseña no tiene el formato requerido',
            containsNumber: 'La contraseña no tiene el formato requerido',
            minlength: 'La contraseña no tiene el formato requerido',
            maxlength: 'La nueva contraseña es demasiado larga',
            notEqualTo: 'La nueva contraseña no puede ser igual a la antigua contraseña'
        },
        'confirmNewPassword': {
            required: 'La confirmación de la nueva contraseña es requerida',
            trimming: 'La confirmación de la nueva contraseña es requerida',
            maxlength: 'La confirmación de la nueva contraseña es demasiado larga',
            equalTo: 'La confirmación de la nueva contraseña no coincide con la nueva contraseña'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}