export default {
    rules: {
        'name': {
            required: true,
            maxlength: 255
        },
        'description': {
            required: true,
            maxlength: 255
        }
    },
    messages: {
        'name': {
            required: 'El nombre del nivel es requerido',
            maxlength: 'El nombre del nivel no puede contener más de 255 caracteres'
        },
        'description': {
            required: 'La descripción del nivel es requerida',
            maxlength: 'La descripción del nivel no puede contener más de 255 caracteres'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}