import $ from 'jquery';
import { sendMessage } from './controllers/chat.controller';

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

$('#message').on('keydown', function(event) {
    if(event.keyCode == 13) {
        sendMessage(event);
    }
});

$('#send-message').on('click', sendMessage);