import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';

import User from '../models/user.model';
import { createImage } from '../services/image.service';
import { createUser, loginUser } from '../services/user.service';

export const login = async function(event) {
    event.preventDefault();
    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const btnSubmit = document.getElementById('btn-login');
    btnSubmit.disabled = true;
    const loginSpinner = document.getElementById('login-spinner');
    loginSpinner.classList.remove('d-none');

    const response = await loginUser({});
    loginSpinner.classList.add('d-none');
    btnSubmit.disabled = false;

    if (response.ok) {
        await Swal.fire({
            icon: 'success',
            title: '¡Bienvenido de vuelta a Cursotopia! 😊',
            confirmButtonText: 'Avanzar',
            confirmButtonColor: '#5650DE',
            background: '#FFFFFF',
            customClass: {
                confirmButton: 'btn btn-primary shadow-none rounded-pill'
            },
        });

        window.location.href = 'home.html';
    }
    else {
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Parece que algo salió mal',
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
    }
}

export const signup = async function(event) {

    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const user = new User();
    const response = await createUser(user);
    if (response.ok) {
        
        await Swal.fire({
            icon: 'success',
            title: '¡Bienvenido a Cursotopia! 😊',
            text: 'Cuna de los mejores cursos de la tierra',
            confirmButtonText: 'Comencemos',
            confirmButtonColor: '#5650DE',
            background: '#FFFFFF',
            customClass: {
                confirmButton: 'btn btn-primary shadow-none rounded-pill'
            },
        });

        // TODO: uri estatica
        window.location.href = "home.html";
    }
    else {
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Parece que algo salió mal',
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
    }
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
    const profilePictureId = document.getElementById('profile-picture-id');
    const defaultImage = '../client/assets/images/perfil.png';
    try {
        const files = Array.from(event.target.files);
        if (files.length === 0) {
            pictureBox.src = defaultImage;
            profilePictureId.value = '';
            $(".user-form").validate().element('#profile-picture-id');
            return;
        }
        const file = files[0];
        const allowedExtensions = /(jpg|jpeg|png|gif)$/i;
        if (!allowedExtensions.exec(file.type)) {
            pictureBox.src = defaultImage;
            profilePictureId.value = '';
            $(".user-form").validate().element('#profile-picture-id');
            return;
        }
        const dataUrl = await readFileAsync(file);
        pictureBox.src = dataUrl;

        const imageId = createImage();
        profilePictureId.value = imageId;
    }
    catch (exception) {
        pictureBox.src = defaultImage;
        profilePictureId.value = '';
    }
    $(".user-form").validate().element('#profile-picture-id');
}

export const updateUser = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    if (true) {
        
        await Swal.fire({
            icon: 'success',
            title: 'Tú perfil se actualizó exitosamente',
            confirmButtonText: 'Continuar',
            confirmButtonColor: '#5650DE',
            background: '#FFFFFF',
            customClass: {
                confirmButton: 'btn btn-primary shadow-none rounded-pill'
            },
        });

        // TODO: uri estatica
        window.location.href = "home.html";
    }
    else {
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Parece que algo salió mal',
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
    }
}

export const updatePassword = async function(event) {
    
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    if (true) {
        
        await Swal.fire({
            icon: 'success',
            title: 'Tú contraseña se actualizó exitosamente',
            confirmButtonText: 'Continuar',
            confirmButtonColor: '#5650DE',
            background: '#FFFFFF',
            customClass: {
                confirmButton: 'btn btn-primary shadow-none rounded-pill'
            },
        });

        // TODO: uri estatica
        window.location.href = "home.html";
    }
    else {
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Parece que algo salió mal',
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
    }
}