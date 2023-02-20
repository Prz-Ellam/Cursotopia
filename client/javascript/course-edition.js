import $ from './jquery-global';
import 'jquery-validation';
import 'multiple-select';
import 'bootstrap';

$('#categories').multipleSelect({
    placeholder: 'Seleccionar',
    selectAll: false,
    width: '100%',
    filter: true
});