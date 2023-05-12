import { Tooltip } from 'bootstrap';
import $ from 'jquery';
import { createMessageService, getAllChatMessageService } from '../services/chat-message.service';
import { findUserChats } from '../services/chat.service';
import { ToastBottom } from '../utilities/toast';
import { createComment } from '../views/comment.view';
import { createMessages } from '../views/message.view';

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

export const loadMessages = async (chatId) => {
    $('#message-box').html('');
    const { messages, userId } = await getAllChatMessageService(chatId);
    
    createMessages(messages, userId);
    $('#box-div').removeClass('d-none');
    const chats = await findUserChats();
    $('#chat-drawer').empty().append(chats);

    const messageBox = document.getElementById('message-box');
    messageBox.scrollTo({
        left: 0,
        top: messageBox.scrollHeight
    });

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))
}