$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

export default {
    rules: {
        'title': {
            required: true,
            trimming: true,
            maxlength: 50
        },
        'description': {
            required: true,
            trimming: true,
            maxlength: 255
        },
        
    },
    messages: {
        'title': {
            required: 'El título del nivel es requerido',
            trimming: 'El título del nivel es requerido',
            maxlength: 'El nombre del nivel no puede contener más de 255 caracteres'
        },
        'description': {
            required: 'La descripción del nivel es requerida',
            trimming: 'La descripción del nivel es requerida',
            maxlength: 'La descripción del nivel no puede contener más de 255 caracteres'
        },
        
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        let targetElement = element;
        if (element.attr('name') === 'price') {
            targetElement = element.parent();
        }
        error.insertAfter(targetElement).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}