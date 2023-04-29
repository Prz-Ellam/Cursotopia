import Swal from 'sweetalert2';

export const showErrorMessage = async (response) => {
    let text = 'Parece que algo salió mal';
    if (typeof response.message === 'object') {
        text = '';
        for (const [_key, value] of Object.entries(response.message)) {
            text += `${value}<br>`;
        }
    } else if (typeof response.message === 'string') {
        text = response.message;
    }
    await Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: text,
        confirmButtonColor: '#de4f54',
        background: '#EFEFEF',
        customClass: {
            confirmButton: 'btn btn-danger shadow-none rounded-pill'
        },
    });
}