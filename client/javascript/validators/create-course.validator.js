export default {
    rules: {
        'title': {
            required: true,
            maxlength:255
        },
        'description': {
            required: true,
            maxlength:255
        },
        'categories[]': {
            required: true
        },
        'price': {
            required: true,
            number:true
        },
        'level-img': {
            required: true
        }
    },
    messages: {
        'title': {
            required: 'El nombre del curso es requerido',
            maxlength:'El nombre del curso no puede contener más de 255 caracteres'
        },
        'description': {
            required: 'La descripción es requerida',
            maxlength:'La descripción no puede contener más de 255 caracteres'
        },
        'categories[]': {
            required: 'La categoria es requerida'
        },
        'price': {
            required: 'El precio es requerido',
            number:'El precio no es válido'
        },
        'level-img': {
            required: 'La imagen es requerida'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
};