import $ from 'jquery';
import { createMessageService } from '../services/chat-message.service';
import { createComment } from '../views/comment.view';

export const sendMessage = async (event) => {
    const message = {
        content: document.getElementById('message').value
    }
    const chatId = document.getElementById('actual-chat-id').value;

    if (message.content.trim() === '') return;

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