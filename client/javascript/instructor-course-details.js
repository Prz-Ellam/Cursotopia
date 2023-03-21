import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 1000,
        easing: "ease-in-out",
        once: true,
        mirror: false
    });

    const btnDeleteCourse = document.querySelector('.btn-delete-course');
    console.log(btnDeleteCourse);
    btnDeleteCourse.addEventListener('click', async function() {
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
            window.location.href = 'home';
        }
    }); 

});