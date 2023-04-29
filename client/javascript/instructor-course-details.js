import $ from 'jquery';
import Swal from 'sweetalert2';
import CourseService from './services/course.service';

$(() => {
    AOS.init({
        duration: 1000,
        easing: "ease-in-out",
        once: true,
        mirror: false
    });

    $('.btn-delete-course').on('click', async function() {
        const feedback = await Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Estás seguro que deseas deshabilitar este curso?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#DD3333',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill',
                cancelButton: 'btn btn-secondary shadow-none rounded-pill'
            }
        });
        if (feedback.isConfirmed) {
            // TODO: uri estatica
            // TODO: quitar el boton de deshabilitar si ya esta deshabilitado
            const params = new URLSearchParams(window.location.search);
            const id = params.get('course_id');
            await CourseService.delete(id);
            window.location.href = 'home';
        }
    }); 

});