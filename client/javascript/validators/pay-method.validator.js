export default {
    rules: {
        'pay-method': {
            required: true
        },
        'name': {
            required: true,
            maxlength:255,
            latinos:true
        },
        'curp': {
            required: true,
            curp:true
        },
        'card-number': {
            required: true,
            digits:true,
            minlength:8,
            maxlength:19
        },
        'cvv': {
            required: true,
            minlength:3,
            maxlength:4
        },
        'exp-month': {
            required: true,
            validMonth:true,
            validDate:true
        },
        'exp-year': {
            required: true,
            validYear:true,
            validDate:true
        }
    },
    messages: {
        'pay-method': {
            required: 'Escoja un método de pago'
        },
        'name': {
            required: 'El nombre de tarjeta es requerido',
            maxlength:'El nombre de tarjeta no puede contener más de 255 caracteres',
            latinos:'El nombre de tarjeta contienen caracteres invalidos'
        },
        'curp': {
            required: 'El CURP es requerido',
            curp:'El CURP no es válido'
        },
        'card-number': {
            required: 'El número de tarjeta es requerido',
            digits:'El número de tarjeta solo puede contener dígitos',
            minlength:'El número de tarjeta menos de 8 caracteres',
            maxlength:'El número de tarjeta contener más de 19 caracteres'
        },
        'cvv': {
            required: 'El CVC/CVV es requerido',
            minlength:'El CVC/CVV no puede contener menos de 3 caracteres',
            maxlength:'El CVC/CVV no puede contener más de 4 caracteres'
        },
        'exp-month': {
            required: 'El mes de expiración es requerido',
            validMonth:'El mes no es válido',
            validDate:'La fecha no es válida',
        },
        'exp-year': {
            required: 'El año de expiración es requerido',
            validYear:'El año no es válido',
            validDate:'La fecha no es válida'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
}; 