import $ from 'jquery';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

export default {
    rules: {
        'rate': {
            required: true
        },
        'message': {
            required: true,
            trimming: true,
            maxlength: 255
        }
    },
    messages: {
        'rate': {
            required: 'La calificación es requerida'
        },
        'message': {
            required: 'La reseña es requerida',
            trimming: 'La reseña es requerida',
            maxlength: 'La reseña es demasiado larga'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    },
    ignore: []
}