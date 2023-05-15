import { Tooltip } from 'bootstrap';
import $ from 'jquery';
import MessageService from '@/services/message.service';
import ChatService from '@/services/chat.service';
import { ToastTopEnd } from '../utilities/toast';
import { createComment } from '../views/comment.view';
import { createMessages } from '../views/message.view';

// TODO: este deberia ir en message
export const sendMessage = async () => {
    const message = {
        content: $('#message').val()
    }
    const chatId = $('#actual-chat-id').val();

    if (message.content.trim() === '') {
        ToastTopEnd.fire({
            icon: 'error',
            title: 'El mensaje no puede estar vacío'
        });
        return;
    }
    if (message.content.trim().length > 255) {
        ToastTopEnd.fire({
            icon: 'error',
            title: 'El mensaje no puede superar 255 caracteres'
        });
        return;
    }

    const response = await MessageService.create(message, chatId);
    if (!response?.status) {
        ToastTopEnd.fire({
            icon: 'error',
            title: 'No se pudo crear el mensaje'
        });
        return;
    }

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
    const { messages, userId } = await MessageService.findAllByChat(chatId);
    
    createMessages(messages, userId);
    $('#box-div').removeClass('d-none');
    const chats = await ChatService.findAllByUser();
    $('#chat-drawer').empty().append(chats);

    const messageBox = document.getElementById('message-box');
    messageBox.scrollTo({
        left: 0,
        top: messageBox.scrollHeight
    });

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))
}