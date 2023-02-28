$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

export default {
    rules: {
        'name': {
            required: true,
            trimming: true,
            maxlength:255
        },
        'description': {
            required: true,
            trimming: true,
            maxlength:255
        }
    },
    messages: {
        'name': {
            required: 'El título es requerido',
            trimming: 'El título es requerido',
            maxlength: 'El título es demasiado largo'
        },
        'description': {
            required: 'La descripción es requerida',
            trimming: 'La descripción es requerida',
            maxlength: 'La descripción es demasiado larga'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        let targetElement = element;
        error.insertAfter(targetElement).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}