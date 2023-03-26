import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';

import { createImage, updateImageService } from '../services/image.service';
import { updateUserService, loginUser, updateUserPasswordService, createUserService } from '../services/user.service';
import { ToastBottom } from '../utilities/toast';

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

    const formData = new FormData(this);
    const user = {};
    for (const [key, value] of formData) {
        user[key] = value;
    }
    
    const response = await loginUser(user);
    loginSpinner.classList.add('d-none');
    btnSubmit.disabled = false;

    if (response.status) {
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

        window.location.href = 'home';
    }
    else {
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response.message,
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
    
    const formData = new FormData(this);
    const user = {
        name:       formData.get('name'),
        lastName:   formData.get('lastName'),
        birthDate:  formData.get('birthDate'),
        gender:     formData.get('gender'),
        userRole:   parseInt(formData.get('userRole')),
        email:      formData.get('email'),
        password:   formData.get('password'),
        confirmPassword: formData.get('confirmPassword'),
        profilePicture: parseInt(formData.get('profilePicture'))
    }

    const response = await createUserService(user);
    console.log(response);
    if (response?.status) {
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
        window.location.href = "home";
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

// TODO: changeProfilePicture
let previousFile = '';
export const uploadProfilePicture = async function(event) {    
    const pictureBox = document.getElementById('picture-box');
    const inputFile = document.getElementById('profile-picture');
    const profilePictureId = document.getElementById('profile-picture-id');
    const defaultImage = '../client/assets/images/perfil.png';

    console.log(previousFile);
    try {
        const files = Array.from(event.target.files);
        if (files.length === 0) {
            inputFile.value = previousFile;
            return;
        }
        const file = files[0];

        const allowedExtensions = [ 'image/jpg', 'image/jpeg', 'image/png' ];
        if (!allowedExtensions.includes(file.type)) {
            await Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'El tipo de archivo que selecciono no es admitido',
                confirmButtonColor: "#dc3545",
                customClass: {
                    confirmButton: 'btn btn-danger shadow-none rounded-pill'
                },
            });
            //pictureBox.src = defaultImage;
            //profilePictureId.value = '';
            inputFile.value = previousFile;
            //$(".user-form").validate().element('#profile-picture-id');
            return;
        }

        const size = parseFloat((file.size / 1024.0 / 1024.0).toFixed(2));
        if (size > 8.0) {
            await Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'La imagen es muy pesada',
                confirmButtonColor: "#dc3545",
                customClass: {
                    confirmButton: 'btn btn-danger shadow-none rounded-pill'
                },
            });
            //pictureBox.src = defaultImage;
            //profilePictureId.value = '';
            inputFile.value = previousFile;
            //$(".user-form").validate().element('#profile-picture-id');
            return;
        }

        const dataUrl = await readFileAsync(file);
        pictureBox.src = dataUrl;

        const formData = new FormData();
        formData.append('image', file, file.name);

        if (!profilePictureId.value) {
            const response = await createImage(formData);
            const imageId = response.id;
            //profilePictureId.value = imageId;
        }
        else {
            const response = await updateImageService(formData, profilePictureId.value);
        }
        previousFile = file;
        ToastBottom.fire({
            icon: 'success',
            title: 'Se ha actualizado la imagen'
        });
    }
    catch (exception) {
        console.log(exception);
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

    const formData = new FormData(this);
    const user = {
        name:       formData.get('name'),
        lastName:   formData.get('lastName'),
        birthDate:  formData.get('birthDate'),
        gender:     formData.get('gender'),
        email:      formData.get('email')
    };

    const response = await updateUserService(user, formData.get('id'));
    if (response?.status) {
        
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
        window.location.href = 'home';
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
        event.preventDefault();
    }
}

export const updatePassword = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const formData = new FormData(this);
    const user = {
        oldPassword: formData.get('oldPassword'),
        newPassword: formData.get('newPassword'),
        confirmNewPassword: formData.get('confirmNewPassword')
    };

    const response = await updateUserPasswordService(user, formData.get('id'));
    if (response.status) {
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
        window.location.href = "home";
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