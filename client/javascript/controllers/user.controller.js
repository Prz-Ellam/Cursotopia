import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import { Toast } from '../utilities/toast';
import { showBlockedUsers, showUnblockedUsers} from '../views/user.view';
import { createImage, updateImageService } from '../services/image.service';
import { updateUserService, loginUser, updateUserPasswordService, createUserService, blockUserService, unblockUserService, findBlockedUsers, findUnblockedUsers } from '../services/user.service';
import { showErrorMessage } from '../utilities/show-error-message';
import { ToastBottom } from '../utilities/toast';

export const submitLogin = async function(event) {
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
    console.log(response);
    if (response?.status) {
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

        window.location.href = '/home';
    }
    else {
        let text = response.message ?? 'Parece que algo salió mal';
        if (response.message instanceof Object) {
            text = '';
            for (const [key, value] of Object.entries(response.message)) {
                text += `${value}<br>`;
            }
        }
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: text,
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
    }
}

export const submitSignup = async function(event) {
    event.preventDefault();

    // Validaciones del formulario
    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }
    
    // Obtengo y formato de los datos del formulario
    const formData = new FormData(this);
    const user = {
        name:               formData.get('name'),
        lastName:           formData.get('lastName'),
        birthDate:          formData.get('birthDate'),
        gender:             formData.get('gender'),
        userRole:           Number.parseInt(formData.get('userRole')),
        email:              formData.get('email'),
        password:           formData.get('password'),
        confirmPassword:    formData.get('confirmPassword')
    }

    const userForm = new FormData();
    userForm.append('payload', JSON.stringify(user));
    userForm.append('image', formData.get('image'));

    // Envio de datos a la API
    const response = await createUserService(userForm);
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
        window.location.href = '/home';
    }
    else {
        showErrorMessage(response);
    }
}

/**
 * 
 * @param {string} passwordInput 
 * @param {string} selectorMayus 
 * @param {string} selectorNumber 
 * @param {string} selectorSpecialChar 
 * @param {string} selectorLength 
 * @returns 
 */
export const passwordStrength = function(passwordInput, selectorMayus, selectorNumber, selectorSpecialChar, selectorLength) {
    const value = $(passwordInput).val();
    
    if (value === '') {
        $(selectorMayus).removeClass('text-danger text-success');
        $(selectorNumber).removeClass('text-danger text-success');
        $(selectorSpecialChar).removeClass('text-danger text-success');
        $(selectorLength).removeClass('text-danger text-success');
        return;
    }
  
    if (/[A-Z]/g.test(value)) {
        $(selectorMayus).addClass('text-success').removeClass('text-danger');
    }
    else {
        $(selectorMayus).addClass('text-danger').removeClass('text-success')
    }
  
    if (/[0-9]/g.test(value)) {
        $(selectorNumber).addClass('text-success').removeClass('text-danger');
    }
    else {
        $(selectorNumber).addClass('text-danger').removeClass('text-success')
    }
  
    if (/([°|¬!"#$%&/()=?¡'¿¨*\]´+}~`{[^;:_,.\-<>@])/.test(value)) {
        $(selectorSpecialChar).addClass('text-success').removeClass('text-danger');
    }
    else {
        $(selectorSpecialChar).addClass('text-danger').removeClass('text-success')
    }
  
    if (value.length >= 8) {
        $(selectorLength).addClass('text-success').removeClass('text-danger');
    }
    else {
        $(selectorLength).addClass('text-danger').removeClass('text-success');
    }
}

/**
 * Cambia de visible a no visible un input de contraseña
 * 
 * @param {string} selectorInput
 * @param {string} selectorIcon
 */
export const passwordToggle = function(selectorInput, selectorIcon) {
    $(selectorIcon).toggleClass('fa-eye fa-eye-slash');
    $(selectorInput).prop('type', ($(selectorInput).prop('type') === 'password') ? 'text' : 'password')
}

export const blockUser = async function(userId) {

    const response = await blockUserService(userId);
    if (response?.status) {
        $('#blockUsers').empty();
        $('#unblockUsers').empty();
        const blockedUsers = await findBlockedUsers();
        const unblockedUsers = await findUnblockedUsers();
        if (blockedUsers?.status && unblockedUsers?.status) {
            const blocked = blockedUsers.blockedUsers;
            const unblocked = unblockedUsers.unblockedUsers;
            blocked.forEach(user => {
                showBlockedUsers(user);
            });
            unblocked.forEach(user => {
                showUnblockedUsers(user);
            });
        }
        Toast.fire({
            icon: 'success',
            title: 'El usuario ha sido bloqueado'
        });
        return;
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }
}

export const unblockUser = async function(userId) {

    const response = await unblockUserService(userId);
    if (response?.status) {
        $('#blockUsers').empty();
        $('#unblockUsers').empty();
        const blockedUsers = await findBlockedUsers();
        const unblockedUsers = await findUnblockedUsers();
        if (blockedUsers?.status && unblockedUsers?.status) {
            const blocked = blockedUsers.blockedUsers;
            const unblocked = unblockedUsers.unblockedUsers;
            blocked.forEach(user => {
                showBlockedUsers(user);
            });
            unblocked.forEach(user => {
                showUnblockedUsers(user);
            });
        }
        Toast.fire({
            icon: 'success',
            title: 'El usuario ha sido desbloqueado'
        });
        return;
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }
}





// TODO: changeProfilePicture
let previousFile = '';
export const changeProfilePicture = async function(event) {
    const inputFile = document.getElementById('profile-picture');
    const profilePictureId = document.getElementById('profile-picture-id');
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
                confirmButtonColor: "#DC3545",
                customClass: {
                    confirmButton: 'btn btn-danger shadow-none rounded-pill'
                },
            });
            return;
        }

        if (file.size >= 8 * 1024 * 1024) {
            await Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'La imagen es muy pesada (máximo 8MB)',
                confirmButtonColor: "#DC3545",
                customClass: {
                    confirmButton: 'btn btn-danger shadow-none rounded-pill'
                },
            });
            return;
        }

        const formData = new FormData();
        formData.append('image', file, file.name);

        const spinner = document.getElementById('change-profile-picture-spinner');
        spinner.style.visibility = 'visible';
        $('.profile-picture-label').css('visibility', 'hidden');

        const response = await updateImageService(formData, profilePictureId.value);
        spinner.style.visibility = 'hidden';
        $('.profile-picture-label').css('visibility', 'visible');

        if (!response?.status) {
            ToastBottom.fire({
                icon: 'error',
                title: 'No se pudo actualizar la imagen'
            });
            return;
        }

        const dataUrl = await readFileAsync(file);
        $('#picture-box').attr('src', dataUrl);
        $('.profile-picture').attr('src', dataUrl);
        ToastBottom.fire({
            icon: 'success',
            title: 'Se ha actualizado la imagen'
        });
    }
    catch (exception) {
        console.log(exception);
    }
}


export const uploadProfilePicture = async function(event) {    
    const pictureBox = document.getElementById('picture-box');
    const inputFile = document.getElementById('profile-picture');
    const defaultImage = '../client/assets/images/perfil.png';

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

        //const formData = new FormData();
        //formData.append('image', file, file.name);
        /*
        if (!profilePictureId.value) {
            const response = await createImage(formData);
            if (!response?.status) {
                ToastBottom.fire({
                    icon: 'error',
                    title: 'No se pudo cargar la imagen'
                });
                return;
            }
            const imageId = response.id;
            profilePictureId.value = imageId;
        }
        else {
            const response = await updateImageService(formData, profilePictureId.value);
            
        }
        */
        const dataUrl = await readFileAsync(file);
        pictureBox.src = dataUrl;
        $('.profile-picture').attr('src', dataUrl);
        previousFile = file;
        
    }
    catch (exception) {
        console.log(exception);
        pictureBox.src = defaultImage;
    }
    //$(".user-form").validate().element('#profile-picture-id');

}

export const updateUser = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
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

    //document.getElementById('submit-btn').disabled = false;
    const response = await updateUserService(user, formData.get('id'));
    //document.getElementById('submit-btn').disabled = true;
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
        window.location.href = '/home';
    }
    else {
        showErrorMessage(response);
    }
}

export const updatePassword = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    const formData = new FormData(this);
    const user = {
        oldPassword: formData.get('oldPassword'),
        newPassword: formData.get('newPassword'),
        confirmNewPassword: formData.get('confirmNewPassword')
    };

    //document.getElementById('btn-submit').disabled = false;
    const response = await updateUserPasswordService(user, formData.get('id'));
    //document.getElementById('btn-submit').disabled = true;
    if (response?.status) {
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
        window.location.href = '/home';
    }
    else {
        showErrorMessage(response);
    }
}