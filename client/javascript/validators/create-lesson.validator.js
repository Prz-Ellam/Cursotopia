import $ from 'jquery';
import 'jquery-validation';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

// Data size (no puede pesar mas de 8MB)
$.validator.addMethod('filesize', function (value, element, parameter) {
    let result;
    if (element.files[0] === undefined) {
        return this.optional(element) || result;
    }
    const size = parseFloat((element.files[0].size / 1024.0 / 1024.0).toFixed(2));
    result = (size > parameter) ? false : true;
    return this.optional(element) || result;
}, 'Please enter a valid file');

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
        'video': {
            filesize: 4 * 1024
        },
        'image': {
            filesize: 8
        },
        'pdf': {
            filesize: 8
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
        'video': {
            filesize: 'El video no puede pesar más de 4GB'
        },
        'image': {
            filesize: 'La imágen no puede pesar más de 8MB'
        },
        'pdf': {
            filesize: 'El documento no puede pesar más de 8MB'
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