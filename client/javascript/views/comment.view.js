import $ from 'jquery';
import ejs from 'ejs';
import { Tooltip } from 'bootstrap';

export const createComment = (message) => {
    const template = `
    <div class="d-flex justify-content-end my-3">
        <small
            class="bg-primary text-light p-2 rounded-pill overflow-auto"
            data-bs-toggle="tooltip"
            data-bs-placement="<%= message.sender ? 'right' : 'left' %>"
            data-bs-title="26 de enero de 2023 a las 02:21">
            <%= message.content %>
        </small>
    </div>
    `;
    const html = ejs.render(template, { message });
    $('#message-box').append(html);
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))
}