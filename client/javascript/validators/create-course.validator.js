export default {
    rules: {
        'title': {
            required: true
        },
        'description': {
            required: true
        }
    },
    messages: {
        'title': {
            required: 'El título es requerido'
        },
        'description': {
            required: 'La descripción es requerida'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}