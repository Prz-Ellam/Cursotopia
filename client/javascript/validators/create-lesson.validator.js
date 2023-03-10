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

$.validator.addMethod('image', function (value, element) {
    if (element.files.length === 0) {
        return true;
    }
    const file = element.files[0];
    const allowedExtensions = /(jpg|jpeg|png|gif)$/i;
    if (!allowedExtensions.exec(file.type)) {
        return false;
    }
    return true;
}, 'Please enter a valid file');

$.validator.addMethod('document', function (value, element) {
    if (element.files.length === 0) {
        return true;
    }
    const file = element.files[0];
    const allowedExtensions = /(pdf)$/i;
    if (!allowedExtensions.exec(file.type)) {
        return false;
    }
    return true;
}, 'Please enter a valid file');

$.validator.addMethod('video', function (value, element) {
    if (element.files.length === 0) {
        return true;
    }
    const file = element.files[0];
    const allowedExtensions = /(mp4)$/i;
    if (!allowedExtensions.exec(file.type)) {
        return false;
    }
    return true;
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
            filesize: 4 * 1024,
            video: true
        },
        'image': {
            filesize: 8,
            image: true
        },
        'pdf': {
            filesize: 8,
            document: true
        },
        'resource': {
            resource: true
        }
    },
    messages: {
        'title': {
            required: 'El t??tulo de la lecci??n es requerido',
            trimming: 'El t??tulo de la lecci??n es requerido'
        },
        'description': {
            required: 'La descripci??n de la lecci??n es requerida',
            trimming: 'La descripci??n de la lecci??n es requerida'
        },
        'video': {
            filesize: 'El video no puede pesar m??s de 4GB',
            video: 'El archivo seleccionado no cumple con el formato esperado'
        },
        'image': {
            filesize: 'La im??gen no puede pesar m??s de 8MB',
            image: 'El archivo seleccionado no cumple con el formato esperado'
        },
        'pdf': {
            filesize: 'El documento no puede pesar m??s de 8MB',
            document: 'El archivo seleccionado no cumple con el formato esperado'
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