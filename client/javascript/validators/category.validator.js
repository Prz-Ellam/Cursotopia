export default {
    rules: {
        'name': {
            required: true,
            maxlength:255
        },
        'description': {
            required: true,
            maxlength:255
        },
    },
    messages: {
        'name': {
            required: 'El nombre de la categoría es requerido',
            maxlength:'El nombre de la categoría no puede contener más de 255 caracteres'
        },
        'description': {
            required: 'La de descripción es requerida',
            maxlength:'La descripción no puede contener más de 255 caracteres'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}; 