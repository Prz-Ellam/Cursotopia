import $ from 'jquery';

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

$('#new-password').on('input', function() {

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