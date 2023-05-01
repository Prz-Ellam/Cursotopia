import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import { createEnrollmentService } from '../services/enrollment.service';

export const enroll = async function(event) {
    event.preventDefault();

    const payment = {
        courseId: Number.parseInt(new URLSearchParams(window.location.search).get('id') || ''),
        amount: null,
        paymentMethodId: null
    };
    
    const response = await createEnrollmentService(payment);
    if (response.status) {
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

export const payment = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    const formData = new FormData(this);
    const payment = {
        courseId: Number.parseInt(new URLSearchParams(window.location.search).get('courseId') || ''),
        amount: Number.parseFloat(formData.get('amount')),
        paymentMethodId: Number.parseInt(formData.get('paymentMethodId'))
    };
    
    const response = await createEnrollmentService(payment);
    if (response.status) {
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