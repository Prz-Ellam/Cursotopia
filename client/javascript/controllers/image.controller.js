import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import ImageService from '@/services/image.service';
import { ToastBottom } from '@/utilities/toast';
import { readFileAsync } from '@/utilities/file-reader';

/**
 * 
 * @param {*} event 
 * @param {string} selectorInput 
 * @param {string} selectorImage 
 * @param {string} defaultImage 
 * @returns 
 */
export const displayImageFile = async function(event, selectorInput, selectorImage, defaultImage) {
    try {
        const files = Array.from(event.target.files);
        if (files.length === 0) {
            $(selectorInput).val('');
            $(selectorImage).attr('src', defaultImage);
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
            $(selectorInput).val('');
            $(selectorImage).attr('src', defaultImage);
            $("#signup-form").validate().element('#profile-picture');
            return;
        }

        const maxFilesize = 8 * 1024 * 1024;
        if (file.size > maxFilesize) {
            await Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'La imagen es muy pesada',
                confirmButtonColor: "#dc3545",
                customClass: {
                    confirmButton: 'btn btn-danger shadow-none rounded-pill'
                },
            });
            $(selectorInput).val('');
            $(selectorImage).attr('src', defaultImage);
            $("#signup-form").validate().element('#profile-picture');
            return;
        }

        const dataUrl = await readFileAsync(file);
        $(selectorImage).attr('src', dataUrl);
        //$('#signup-form').validate().element(selectorInput);
    }
    catch (exception) {
        console.log(exception);
        $(selectorInput).val('');
        $(selectorImage).attr('src', defaultImage);
    }
}

export const changeImage = async function(event, selectorInput, selectorImage, defaultImage) {
    const inputFile = $(selectorInput);
    const profilePictureId = $('#course-cover-id').val();
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

        //const spinner = document.getElementById('change-profile-picture-spinner');
        //spinner.style.visibility = 'visible';
        //$('.profile-picture-label').css('visibility', 'hidden');

        const response = await ImageService.update(formData, profilePictureId);
        //spinner.style.visibility = 'hidden';
        //$('.profile-picture-label').css('visibility', 'visible');

        if (!response?.status) {
            ToastBottom.fire({
                icon: 'error',
                title: 'No se pudo actualizar la imagen'
            });
            return;
        }

        const dataUrl = await readFileAsync(file);
        $('#picture-box').attr('src', dataUrl);
        if (window.location.pathname === '/profile-edition') {
            $('.profile-picture').attr('src', dataUrl);
        }
        ToastBottom.fire({
            icon: 'success',
            title: 'Se ha actualizado la imagen'
        });
    }
    catch (exception) {
        console.log(exception);
    }
}