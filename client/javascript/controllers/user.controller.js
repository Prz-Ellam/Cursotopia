import $ from 'jquery';
import 'jquery-validation';

import User from '../models/user.model';
import { createImage } from '../services/image.service';
import { createUser, loginUser } from '../services/user.service';

export const login = async function(event) {
    event.preventDefault();
    let validations = $(this).valid();
    if (!validations) {
        return;
    }

    const btnSubmit = document.getElementById('btn-login');
    btnSubmit.disabled = true;
    const loginSpinner = document.getElementById('login-spinner');
    loginSpinner.classList.remove('d-none');

    const auth = {
        email: 'PerezAlex088@outlook.com',
        password: '123Abc!!'
    };

    const response = await loginUser(auth);
    loginSpinner.classList.add('d-none');
    btnSubmit.disabled = false;
}

export const signup = async function(event) {

    console.log('Hola Mundo');
    //event.preventDefault();

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

function readFileAsync(file) {
    return new Promise((resolve, reject) => {
        const fileReader = new FileReader();
        fileReader.onload = () => {
            resolve(fileReader.result);
        };
        fileReader.onerror = reject;
        fileReader.readAsDataURL(file);
    });
}

export const uploadProfilePicture = async function(event) {
    const pictureBox = document.getElementById('picture-box');
    const defaultImage = '../client/assets/images/perfil.png';
    try {
        const files = Array.from(event.target.files);
        if (files.length === 0) {
            pictureBox.src = defaultImage;
            return;
        }
        const file = files[0];
        const allowedExtensions = /(jpg|jpeg|png|gif)$/i;
        if (!allowedExtensions.exec(file.type)) {
            pictureBox.src = defaultImage;
            return;
        }
        const dataUrl = await readFileAsync(file);
        pictureBox.src = dataUrl;

        createImage();
    }
    catch (exception) {
        pictureBox.src = defaultImage;
    }
}

export const updateUser = function(event) {

}