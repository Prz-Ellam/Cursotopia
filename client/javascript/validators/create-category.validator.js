export default {
    rules: {
        'name': {
            required: true,
            maxlength:255
        },
        'description': {
            required: true,
            maxlength:255
        }
    },
    messages: {
        'name': {
            required: 'El título es requerido'
        },
        'description': {
            required: 'La descripción es requerida'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        let targetElement = element;
        error.insertAfter(targetElement).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}