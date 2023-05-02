import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';

export function readFileAsync(file) {
    return new Promise((resolve, reject) => {
        const fileReader = new FileReader();
        fileReader.onload = () => {
            resolve(fileReader.result);
        };
        fileReader.onerror = reject;
        fileReader.readAsDataURL(file);
    });
}

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
            $(selectorImage).attr('src', defaultImage);
            //inputFile.value = previousFile;
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
            return;
        }

        const size = Number.parseFloat((file.size / 1024.0 / 1024.0).toFixed(2));
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