export default {
    rules: {
        'edit-name': {
            required: true,
            maxlength:255,
            latinos:true
        },
        'edit-last-name': {
            required: true,
            maxlength:255,
            latinos:true
        },
        'edit-gender': {
            required: true
        },
        'edit-birthday': {
            required: true,
            validDate:true,
            date:true
        },
        'edit-email': {
            required: true,
            validEmail:true
        },
        'edit-user': {
            required: true,
            noSpace:true
        },
        'edit-password': {
            required: true,
            containsNumber:true,
            containsMayus:true,
            containsSpecialCharacter:true,
            minlength:8
        },
        'retype-password': {
            required: true,
            equalTo:"#edit-password"
        }
    },
    messages: {
        'edit-name': {
            required: 'El nombre es requerido',
            maxlength:'El nombre no puede contener más de 255 caracteres',
            latinos:'El nombre contienen caracteres invalidos'
        },
        'edit-last-name': {
            required: 'El apellido es requerido',
            maxlength:'El apellido no puede contener más de 255 caracteres',
            latinos:'El apellido contiene caracteres invalidos'
        },
        'edit-gender': {
            required: 'El género de usuario es requerido'
        },
        'edit-birthday': {
            required:'La fecha de nacimiento es requerida',
            validDate:'La fecha de nacimiento no es válida',
            date:'La fecha de nacimiento no es válida'
        },
        'edit-email': {
            required: 'El correo electrónico es requerido',
            validEmail:'El correo electrónico no es válido',
            email:'El correo electrónico no es válido'
        },
        'edit-user': {
            required:'El nombre de usuario es requerido',
            noSpace:'El nombre de usuario no debe contener espacio'
        },
        'edit-password': {
            required: 'La contraseña es requerida',
            containsNumber:'La contraseña debe contener al menos un dígito',
            containsMayus:'La contraseña de contener al menos una mayúscula',
            containsSpecialCharacter:'La contraseña debe contener al menos un carácter especial',
            minlength:'La contraseña debe contener al menos 8 caracteres'
        },
        'retype-password': {
            required: 'Confirmar contraseña es requerido',
            equalTo:'Las contraseñas no concuerdan'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}; 

