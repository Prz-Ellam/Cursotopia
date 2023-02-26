import $ from 'jquery';
import 'jquery-validation';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

$.validator.addMethod('resource', function(value, element) {
    const video = document.getElementById('create-lesson-video');
    const image = document.getElementById('create-lesson-image');
    const pdf = document.getElementById('create-lesson-pdf');
    const linkTitle = document.getElementById('create-lesson-link-title');
    const linkUrl = document.getElementById('create-lesson-link-url');

    let result;
    if (video.value === '' && image.value === '' && pdf.value === '' && 
        (linkTitle.value === '' || linkUrl.value === '')) {
        result = false;
    }
    else {
        result = true;
    }

    return result;
}, 'Please enter a valid');

export default {
    rules: {
        'title': {
            required: true,
            trimming: true
        },
        'description': {
            required: true,
            trimming: true
        },
        'resource': {
            resource: true
        }
    },
    messages: {
        'title': {
            required: 'El título de la lección es requerido',
            trimming: 'El título de la lección es requerido'
        },
        'description': {
            required: 'La descripción de la lección es requerida',
            trimming: 'La descripción de la lección es requerida'
        },
        'resource': {
            resource: 'Es requerido al menos un recurso'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    },
    ignore: []
}