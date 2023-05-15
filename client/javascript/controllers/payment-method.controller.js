import $ from 'jquery';
import 'jquery-validation';
import Swal from 'sweetalert2';
import { createEnrollmentService, payEnrollmentService } from '../services/enrollment.service';
import { showErrorMessage } from '../utilities/show-error-message';
import { ToastTopEnd } from '../utilities/toast';

export const enroll = async function(event) {
    event.preventDefault();

    const courseId = new URLSearchParams(window.location.search).get('id') ?? '';
    const payment = {
        courseId: Number.parseInt(courseId),
        paymentMethodId: null
    };

    $('#payment-btn').prop('disabled', true);
    $('#payment-spinner').removeClass('d-none');
    
    const response = await createEnrollmentService(payment);

    $('#payment-spinner').addClass('d-none');
    $('#payment-btn').prop('disabled', false);

    if (!response?.status) {
        await showErrorMessage(response);
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
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Formulario no válido'
        });
        return;
    }

    const formData = new FormData(this);
    const courseId = new URLSearchParams(window.location.search).get('courseId') ?? '';
    const payment = {
        courseId: Number.parseInt(courseId),
        paymentMethodId: Number.parseInt(formData.get('paymentMethodId'))
    };

    $('#payment-btn').prop('disabled', true);
    $('#payment-spinner').removeClass('d-none');
    
    const response = await payEnrollmentService(payment);

    $('#payment-spinner').addClass('d-none');
    $('#payment-btn').prop('disabled', false);
    
    if (!response?.status) {
        await showErrorMessage(response);
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