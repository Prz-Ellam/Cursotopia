import $ from 'jquery';
import 'jquery-validation';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

// Data size (no puede pesar mas de 8MB)
$.validator.addMethod('filesize', function (value, element, parameter) {
    let result = false;
    if (!element.files) {
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
    const allowedExtensions = [ 'image/jpg', 'image/jpeg', 'image/png' ];
    if (!allowedExtensions.includes(file.type)) {
        return false;
    }
    return true;
}, 'Please enter a valid file');

$.validator.addMethod('document', function (value, element) {
    if (element.files.length === 0) {
        return true;
    }
    const file = element.files[0];
    const allowedExtensions = [ 'application/pdf' ];
    if (!allowedExtensions.includes(file.type)) {
        return false;
    }
    return true;
}, 'Please enter a valid file');

$.validator.addMethod('video', function (value, element) {
    if (element.files.length === 0) {
        return true;
    }
    const file = element.files[0];
    const allowedExtensions = [ 'video/mp4' ];
    if (!allowedExtensions.includes(file.type)) {
        return false;
    }
    return true;
}, 'Please enter a valid file');

$.validator.addMethod('createResource', function(value, element) {
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

$.validator.addMethod('linkValid2', function(value, element) {
    const linkTitle = $('#create-lesson-link-title').val();
    const linkUrl = $('#create-lesson-link-url').val();
    console.log(linkTitle !== '' ^ linkUrl !== '')
    return (linkTitle !== '' ^ linkUrl !== '') ? false : true;
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
        'resource': {
            createResource: true
        },
        'link-title': {
            trimming: true,
            maxlength: 255,
        },
        'link-url': {
            trimming: true,
            maxlength: 255,
            linkValid2: true
        }
        /*
        'video': {
            filesize: 4 * 1024,
            video: true
        },
        'image': {
            filesize: 8,
            image: true
        },
        'document': {
            filesize: 8,
            document: true
        },
        'link': {
            resource: true
        }
        */
    },
    messages: {
        'title': {
            required: 'El título es requerido',
            trimming: 'El título es requerido',
            maxlength: 'El título no puede contener más de 50 caracteres'
        },
        'description': {
            required: 'La descripción de la lección es requerida',
            trimming: 'La descripción es requerida',
            maxlength: 'La descripción no puede contener más de 255 caracteres'
        },
        'resource': {
            createResource: 'Debe agregar al menos un recurso'
        },
        'link-title': {
            trimming: 'El nombre del enlace no puede contener solo espacios',
            maxlength: 'El nombre del enlace no puede contener más de 255 caracteres',
        },
        'link-url': {
            trimming: 'La url del enlace no puede contener solo espacios',
            maxlength: 'La url del enlace no puede contener más de 255 caracteres',
            linkValid2: 'Es necesario añadir tanto nombre como url'
        }
        /*
        'video': {
            filesize: 'El video no puede pesar más de 4GB',
            video: 'El archivo seleccionado no cumple con el formato esperado'
        },
        'image': {
            filesize: 'La imágen no puede pesar más de 8MB',
            image: 'El archivo seleccionado no cumple con el formato esperado'
        },
        'document': {
            filesize: 'El documento no puede pesar más de 8MB',
            document: 'El archivo seleccionado no cumple con el formato esperado'
        },
        'link': {
            resource: 'Es requerido al menos un recurso'
        }
        */
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    },
    ignore: []
}