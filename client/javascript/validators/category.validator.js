export default {
    rules: {
        'category-name': {
            required: true,
            maxlength:255
        },
        'category-description': {
            required: true,
            maxlength:255
        },
    },
    messages: {
        'category-name': {
            required: 'El nombre de la categoría es requerido',
            maxlength:'El nombre de la categoría no puede contener más de 255 caracteres'
        },
        'category-description': {
            required: 'La de descripción es requerida',
            maxlength:'La descripción no puede contener más de 255 caracteres'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}; 