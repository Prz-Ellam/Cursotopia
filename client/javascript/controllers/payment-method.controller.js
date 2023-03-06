import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';

export const payment = async function(event) {
    event.preventDefault();
    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    if (true) {
        await Swal.fire({
            icon: 'success',
            title: '¡El curso fue comprado con éxito!',
            confirmButtonText: 'Ir al curso',
            confirmButtonColor: '#5650DE',
            background: '#FFFFFF',
            customClass: {
                confirmButton: 'btn btn-primary shadow-none rounded-pill'
            },
        });

        window.location.href = 'course-visor';
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