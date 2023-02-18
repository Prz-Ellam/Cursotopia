import $ from 'jquery';
import 'jquery-validation';

import User from '../models/user.model';
import { createUser, loginUser } from '../services/user.service';

export const login = async function(event) {
    event.preventDefault();
    let validations = $(this).valid();
    if (!validations) {
        return;
    }

    const auth = {
        email: 'PerezAlex088@outlook.com',
        password: '123Abc!!'
    };

    const response = await loginUser(auth);
}

export const signup = async function(event) {

    console.log('Hola Mundo');
    event.preventDefault();

    let validations = $(this).valid();
    if (!validations) {
        return;
    }

    const user = new User();
    user.name = 'Eliam';
    user.lastName = 'Rodríguez Pérez';
    user.userRole = '1';
    user.gender = '1';
    user.birthDate = '2001-10-26';
    user.email = 'PerezAlex088@outlook.com';
    user.password = '123Abc!!';

    const response = await createUser(user);
}

export const uploadProfilePicture = async function(event) {
    
}

export const updateUser = function(event) {

}