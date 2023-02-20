import $ from 'jquery';
import { createComment } from '../views/comment.view';

export const sendMessage = () => {
    const message = {
        content: document.getElementById('message').value,
        sender: 1
    }

    if (message.content === '') return;

    createComment(message);
    $('#message').val('');
    let messageBox = document.getElementById('message-box');
    messageBox.scrollTo({
        left: 0,
        top: messageBox.scrollHeight,
        behavior: 'smooth'
    });
}