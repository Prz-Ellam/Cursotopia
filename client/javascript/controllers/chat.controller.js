import $ from 'jquery';
import { createMessageService } from '../services/chat-message.service';
import { ToastBottom } from '../utilities/toast';
import { createComment } from '../views/comment.view';

// TODO: este deberia ir en message
export const sendMessage = async () => {
    const message = {
        content: $('#message').val()
    }
    const chatId = $('#actual-chat-id').val();

    if (message.content.trim() === '') {
        await ToastBottom.fire({
            icon: 'error',
            title: 'El mensaje no puede estar vacío'
        });
        return;
    }
    if (message.content.trim().length > 255) {
        await ToastBottom.fire({
            icon: 'error',
            title: 'El mensaje no puede superar 255 caracteres'
        });
        return;
    }

    const response = await createMessageService(message, chatId);
    
    createComment(message);
    $('#message').val('');
    let messageBox = document.getElementById('message-box');
    messageBox.scrollTo({
        left: 0,
        top: messageBox.scrollHeight,
        behavior: 'smooth'
    });
}