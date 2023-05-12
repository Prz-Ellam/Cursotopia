import $ from 'jquery';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

export default {
    rules: {
        'rate': {
            required: true,
            min: 1,
            max: 5
        },
        'message': {
            required: true,
            trimming: true,
            maxlength: 255
        }
    },
    messages: {
        'rate': {
            required: 'La calificación es requerida',
            min: 'La calificación no puede ser menor que 1',
            max: 'La calificación no puede ser mayor que 5'
        },
        'message': {
            required: 'La reseña es requerida',
            trimming: 'La reseña es requerida',
            maxlength: 'La reseña no puede contener más de 255 caracteres'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    },
    ignore: []
}