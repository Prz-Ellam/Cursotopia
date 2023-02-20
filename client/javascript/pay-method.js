import $ from 'jquery';
import 'jquery-validation';
import payMethodValidator from './validators/pay-method.validator';

$('#pay-form').validate(payMethodValidator);

$.validator.addMethod('latinos',function(value,element){
    var pattern=/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?: [a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/;
    return this.optional(element) || pattern.test(value);
})

$.validator.addMethod('curp',function(value,element){
    var pattern=/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/;
    return this.optional(element) || pattern.test(value);
})

$.validator.addMethod('validMonth',function(value,element){
    var pattern=/^01|02|03|04|05|06|07|08|09|10|11|12$/;
    return this.optional(element) || pattern.test(value);
})

$.validator.addMethod('validDate',function(value,element){
    var month=$("#exp-month").val();
    var year=$("#exp-year").val();
    return this.optional(element) || year==="2023"&&month>2;
})

$.validator.addMethod('validYear',function(value,element){
    var pattern=/^2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
    return this.optional(element) || pattern.test(value);
})