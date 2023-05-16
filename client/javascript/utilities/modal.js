import { Modal } from 'bootstrap';

export const showModal = (selector) => {
    const modal = document.querySelector(selector);
    const modalInstance = new Modal(modal);
    modalInstance.show();
}

export const hideModal = (selector) => {
    const modal = document.querySelector(selector);
    const modalInstance = Modal.getInstance(modal);
    modalInstance.hide();
}
