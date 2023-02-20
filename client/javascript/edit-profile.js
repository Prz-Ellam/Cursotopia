import $ from 'jquery';
import 'jquery-validation';
import editProfileValidator from './validators/edit-profile.validator';


$('#edit-profile-modal').validate(editProfileValidator);

$.validator.addMethod('latinos',function(value,element){
    var pattern=/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?: [a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/;
    return this.optional(element) || pattern.test(value);
})

$.validator.addMethod('validDate',function(value,element){
    var today=new Date();
    var birthday= new Date(value);
    return this.optional(element) || birthday<today /* || birthday.getFullYear()>1903  */
})

$.validator.addMethod('validEmail',function(value,element){
    var pattern=/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    return this.optional(element) || pattern.test(value);
})

$.validator.addMethod('noSpace',function(value,element){
    return this.optional(element) || value.indexOf(" ")<1;
})

$.validator.addMethod('containsNumber',function(value,element){
    var pattern=/[0-9]/;
    return this.optional(element) || pattern.test(value);
})

$.validator.addMethod('containsMayus',function(value,element){
    var pattern=/[A-Z]/;
    return this.optional(element) || pattern.test(value);
})

$.validator.addMethod('containsSpecialCharacter',function(value,element){
    var pattern=/([°|¬!"#$%&/()=?¡'¿¨*\]´+}~`{[^;:_,.\-<>@\\])/;
    return this.optional(element) || pattern.test(value);
})

