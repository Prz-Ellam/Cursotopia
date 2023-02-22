export default {
    rules: {
        'rate': {
            required: true
        },
        'message': {
            required: true
        }
    },
    messages: {
        'rate': {
            required: 'La calificación es requerida'
        },
        'message': {
            required: 'La reseña es requerida'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    },
    ignore: []
}