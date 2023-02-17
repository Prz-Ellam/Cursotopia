import $ from 'jquery';
import 'jquery-validation';

export const createCourse = function(event) {
    event.preventDefault();

    let validations = $(this).valid();
    if (!validations) {
        console.error('Mal');
        return;
    }

    console.log('C');
}

export const updateCourse = function(event) {

}

export const deleteCourse = function(event) {

}

export const findAllByInstructor = function(event) {

}
