import $ from 'jquery';

export const createMessages = (messages, userId) => {
    messages.forEach(message => {
        $('#message-box').append(`
        <div class="d-flex ${ userId === message.userId ? 'justify-content-end' : 'justify-content-start' } my-3">
            <small
                class="${ userId === message.userId ? 'bg-primary' : 'bg-secondary' } text-light p-2 rounded-pill overflow-auto"
                data-bs-toggle="tooltip"
                data-bs-placement="${ userId === message.userId ? 'left' : 'right' }"
                data-bs-title="${ message.createdAt }"
            >
            ${message.content}
            </small>
        </div>
        `);
    });
}