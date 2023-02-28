import $ from 'jquery';

export const createChat = () => {
    const html = `
    <div class="d-flex chat rounded-1 p-1" role="button">
        <img style="width: 64px; height: 64px" class="img-fluid rounded-circle"
            src="https://upload.wikimedia.org/wikipedia/commons/1/16/Saul_Goodman.jpg">
        <div class="row ms-2 align-self-center"
            style="white-space: nowrap; width: 75%; text-overflow: ellipsis; overflow: hidden;">
            <span class="fw-bold">username</span>
            <small>email</small>
        </div>
    </div>
    `;
    $('#chat-section').prepend(html);
}