import $ from 'jquery';
import 'jquery-validation';

$.validator.addMethod('latinos',function(value,element){
    var pattern=/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?: [a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/;
    return this.optional(element) || pattern.test(value);
})

$.validator.addMethod('curp',function(value,element){
    var pattern=/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/;
    return this.optional(element) || pattern.test(value);
});

$.validator.addMethod('validMonth',function(value,element){
    var pattern=/^01|02|03|04|05|06|07|08|09|10|11|12$/;
    return this.optional(element) || pattern.test(value);
});

$.validator.addMethod('validYear',function(value,element){
    var pattern=/^23|24|25|26|27|28|29|30|31$/;
    return this.optional(element) || pattern.test(value);
});

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
        'month': {
            required: true,
            validMonth:true
        },
        'year': {
            required: true,
            validYear:true
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
        'month': {
            required: 'El mes de expiración es requerido',
            validMonth:'El mes no es válido'
        },
        'year': {
            required: 'El año de expiración es requerido',
            validYear:'El año no es válido'
        }
    },
    errorElement: 'small',
    errorPlacement: function (error, element) {
        let targetElement = element;
        if (element.attr('id') === 'month' || element.attr('id') === 'year') {
            targetElement = element.parent();
        }
        error.insertAfter(targetElement).addClass('text-danger').addClass('form-text').addClass('d-block').attr('id', element[0].id + '-error-label');
    }
}; 