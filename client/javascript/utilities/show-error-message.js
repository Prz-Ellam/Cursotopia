import Swal from 'sweetalert2';

export const showErrorMessage = async (response) => {
    const { message } = response;
    let text = 'Parece que algo salió mal';
    if (typeof message === 'object') {
        text = '';
        for (const [_key, value] of Object.entries(message)) {
            text += `${value}<br>`;
        }
    } else if (typeof message === 'string') {
        text = message;
    }
    await Swal.fire({
        icon: 'error',
        title: 'No se pudo realizar la operación',
        html: text,
        confirmButtonColor: '#de4f54',
        background: '#FFFFFF',
        customClass: {
            confirmButton: 'btn btn-danger shadow-none rounded-pill'
        },
    });
}