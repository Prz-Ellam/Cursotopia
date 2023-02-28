import $ from 'jquery';
import 'jquery-validation';

$.validator.addMethod('trimming', function(value, element) {
    return this.optional(element) || value.trim() !== '';
}, 'Please enter a valid');

$.validator.addMethod('lessonsRequired', function(value, element) {
    const lessonsContainers = Array.from(document.querySelectorAll('.lessons-container'));
    for (const lessonContainer of lessonsContainers) {
        const lessons = Array.from(lessonContainer.children);
        const lessonsCount = lessonContainer.children.length;

        if (lessonsCount === 0) {
            return false;
        }
    }
    return true;
}, 'Please enter a valid');

$.validator.addMethod('lessonsVideo', function(value, element) {
    const lessonsContainers = Array.from(document.querySelectorAll('.lessons-container'));
    for (const lessonContainer of lessonsContainers) {
        const lessons = Array.from(lessonContainer.children);
        let videoLesson = false;

        for (const lesson of lessons) {
            if (lesson.classList.contains('video')) {
                videoLesson = true;
                break;
            }
        }

        if (!videoLesson) {
            return false;
        }
    }
    return true;
}, 'Please enter a valid');

export default {
    rules: {
        'course-cover': {
            required: true
        },
        'title': {
            required: true,
            trimming: true,
            maxlength:255
        },
        'description': {
            required: true,
            trimming: true,
            maxlength:255
        },
        'categories[]': {
            required: true
        },
        'price': {
            required: true,
            number: true
        },
        'levels[]': {
            required: true,
            lessonsRequired: true,
            lessonsVideo: true
        }
    },
    messages: {
        'course-cover': {
            required: 'La portada del curso es requerida'
        },
        'title': {
            required: 'El nombre del curso es requerido',
            trimming: 'El nombre del curso es requerido',
            maxlength:'El nombre del curso no puede contener más de 255 caracteres'
        },
        'description': {
            required: 'La descripción del curso es requerido',
            trimming: 'La descripción del curso es requerido',
            maxlength:'La descripción del curso no puede contener más de 255 caracteres'
        },
        'categories[]': {
            required: 'La categoria es requerida'
        },
        'price': {
            required: 'El precio es requerido',
            number: 'El precio no es válido',
            min: 'El precio del producto no puede ser negativo'
        },
        'levels[]': {
            required: 'El curso necesita al menos un nivel',
            lessonsRequired: 'Todos los niveles deben tener al menos una lección',
            lessonsVideo: 'Cada nivel debe tener al menos una lección con video'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        let targetElement = element;
        if (element.attr('name') === 'levels[]' || element.attr('name') === 'price') {
            targetElement = element.parent();
        }
        error.insertAfter(targetElement).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    },
    ignore: []
}