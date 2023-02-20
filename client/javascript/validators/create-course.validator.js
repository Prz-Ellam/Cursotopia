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
        'categories': {
            required: true
        },
        'cost': {
            required: true,
            number:true
        },
        'level-img': {
            required: true
        }
    },
    messages: {
        'name': {
            required: 'El nombre del curso es requerido',
            maxlength:'El nombre del curso no puede contener más de 255 caracteres'
        },
        'description': {
            required: 'La descripción es requerida',
            maxlength:'La descripción no puede contener más de 255 caracteres'
        },
        'categories': {
            required: 'La categoria es requerida'
        },
        'cost': {
            required: 'EL costo es requerido',
            number:'El costo no es válido'
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