import $ from './jquery-global';
import 'jquery-validation';
import { payment } from './controllers/payment-method.controller';
import payMethodValidator from './validators/pay-method.validator';

$('#payment-method-form').validate(payMethodValidator);

const paymentMethodForm = document.getElementById('payment-method-form');
paymentMethodForm.addEventListener('submit', payment);
