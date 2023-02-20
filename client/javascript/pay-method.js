import $ from 'jquery';
import 'jquery-validation';
import payMethodValidator from './validators/pay-method.validator';

$('#pay-form').validate(payMethodValidator);
