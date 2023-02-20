import $ from 'jquery';
import ejs from 'ejs';

export const createComment = (message) => {
    const template = `
    <div class="d-flex <%= message.sender ? 'justify-content-end' : 'justify-content-start' %> my-3">
        <small class="<%= message.sender ? 'bg-primary' : 'bg-secondary' %> text-light p-2 rounded-2 overflow-auto"><%= message.content %></small>
    </div>
    `;
    const html = ejs.render(template, { message });
    $('#message-box').append(html);
}