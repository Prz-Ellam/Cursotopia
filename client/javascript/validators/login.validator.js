export default {
    rules: {
        'email': {
            required: true
        }
    },
    messages: {
        'email': {
            required: 'El correo electrónico es requerido'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}