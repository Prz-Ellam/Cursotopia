$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

export default {
    rules: {
        'name': {
            required: true,
            trimming: true,
            maxlength: 50,
            remote: {
                type: 'POST',
                url: '/api/v1/categories/name',
                data: {
                    'name': function () { return $('#category-name').val() },
                    'id': function () { return $('#category-id').val() }
                },
                dataType: 'json'
            }
        },
        'description': {
            required: true,
            trimming: true,
            maxlength: 255
        }
    },
    messages: {
        'name': {
            required: 'El nombre es requerido',
            trimming: 'El nombre es requerido',
            maxlength: 'El nombre no puede contener más de 50 caracteres',
            remote: 'Ya existe una categoría con ese título'
        },
        'description': {
            required: 'La descripción es requerida',
            trimming: 'La descripción es requerida',
            maxlength: 'La descripción no puede contener más de 255 caracteres'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        let targetElement = element;
        error.insertAfter(targetElement).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}