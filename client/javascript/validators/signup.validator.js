export default {
    rules: {
        'name': {
            required: true
        },
        'last-name': {
            required: true
        },
        'user-role': {
            required: true
        },
        'email': {
            required: true
        },
        'password': {
            required: true
        },
        'confirm-password': {
            required: true
        }
    },
    messages: {
        'name': {
            required: 'El nombre es requerido'
        },
        'last-name': {
            required: 'El apellido es requerido'
        },
        'user-role': {
            required: 'El rol de usuario es requerido'
        },
        'email': {
            required: 'El correo electrónico es requerido'
        },
        'password': {
            required: 'La contraseña es requerida'
        },
        'confirm-password': {
            required: 'Confirmar contraseña es requerido'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
};