import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import { createEnrollmentService } from '../services/enrollment.service';
import { showErrorMessage } from '../utilities/show-error-message';

export const enroll = async function(event) {
    event.preventDefault();

    const payment = {
        courseId: Number.parseInt(new URLSearchParams(window.location.search).get('id') || ''),
        amount: null,
        paymentMethodId: null
    };
    
    const response = await createEnrollmentService(payment);
    if (!response?.status) {
        showErrorMessage(response);
        return;
    }
    
    await Swal.fire({
        icon: 'success',
        title: '¡El curso fue obtenido con éxito!',
        confirmButtonText: 'Continuar',
        confirmButtonColor: '#5650DE',
        background: '#FFFFFF',
        customClass: {
            confirmButton: 'btn btn-primary shadow-none rounded-pill'
        },
    });

    window.location.href = '/home';
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
    if (!response?.status) {
        showErrorMessage(response);
        return;
    }
    
    await Swal.fire({
        icon: 'success',
        title: '¡El curso fue comprado con éxito!',
        confirmButtonText: 'Continuar',
        confirmButtonColor: '#5650DE',
        background: '#FFFFFF',
        customClass: {
            confirmButton: 'btn btn-primary shadow-none rounded-pill'
        },
    });

    window.location.href = '/home';
}