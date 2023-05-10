import { sendMessage } from './controllers/chat.controller';
import { getAllChatMessageService } from './services/chat-message.service';
import { findChatService, findUserChats } from './services/chat.service';
import { getAllUsersService } from './services/user.service';

$(async () => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    $('#message').on('keydown', async function(event) {
        if (event.key === 'Enter') {
            await sendMessage();
            const chats = await findUserChats();
            $('#chat-drawer').empty().append(chats);
        }
    });

    $('#send-message').on('click', async function() {
        await sendMessage();
        const chats = await findUserChats();
        $('#chat-drawer').empty().append(chats);
    });

    $(document).on('click', '.chat-drawer', async function(event) {
        const id = $(this).attr('data-id');
        
        // TODO: Esto es raro
        const srcImg = $(`[data-id=${$(this).attr('data-id')}] a div img`).attr('src');
        const name = $(`[data-id=${$(this).attr('data-id')}] a div div p`).text();

        $('.actual-chat-user-image').attr('src', srcImg);
        $('.actual-chat-user-name').text(name);
        
        $('#actual-chat-id').val(id);
        $('#message-box').html('');
        const chatMessages = await getAllChatMessageService(id);
            chatMessages.messages.forEach(message => {
                $('#message-box').append(`
                <div class="d-flex ${ chatMessages.userId === message.userId ? 'justify-content-end' : 'justify-content-start' } my-3">
                    <small
                        class="${ chatMessages.userId === message.userId ? 'bg-primary' : 'bg-secondary' } text-light p-2 rounded-pill overflow-auto"
                        data-bs-toggle="tooltip"
                        data-bs-placement="${ chatMessages.userId === message.userId ? 'left' : 'right' }"
                        data-bs-title="26 de enero de 2023 a las 02:21"
                    >
                    ${message.content}
                    </small>
                </div>
                `);
            });
        $('#box-div').removeClass('d-none');
        const chats = await findUserChats();
        $('#chat-drawer').empty().append(chats);

        const messageBox = document.getElementById('message-box');
        messageBox.scrollTo({
            left: 0,
            top: messageBox.scrollHeight
        });

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    
    });

    $("#search-users").autocomplete({
        delay: 100,
        source: async function(request, response) {
            const data = await getAllUsersService(request.term);
            response($.map(data, function(object) {
                return {
                    label: `<div><img src="api/v1/images/${object.profilePicture}" style="object-fit: cover" class="rounded-circle" height="50" width="50">&nbsp;&nbsp;&nbsp; ` + object.name + ' ' + object.lastName + ' </div>',
                    name: `${object.name} ${object.lastName}`,
                    value: object.id
                };
            }));
        },
        minLength: 1,
        open: function(){
            setTimeout(() => {
                $('.ui-autocomplete').css('z-index', 99999999999999);
            }, 0);
        },
        select: async function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.name);

            const response = await findChatService({ userTwo: ui.item.value });
            console.log(response);
            $('#actual-chat-id').val(response.chatId);

            $('.actual-chat-user-image').attr('src', `/api/v1/images/${ response.user.profilePicture }`);
            $('.actual-chat-user-name').text(`${ response.user.name } ${ response.user.lastName }`);
        
            const chatMessages = await getAllChatMessageService(response.chatId);
            $('#message-box').empty();
            chatMessages.messages.forEach(message => {
                $('#message-box').append(`
                <div class="d-flex ${ chatMessages.userId === message.userId ? 'justify-content-end' : 'justify-content-start' } my-3">
                    <small
                        class="${ chatMessages.userId === message.userId ? 'bg-primary' : 'bg-secondary' } text-light p-2 rounded-pill overflow-auto"
                        data-bs-toggle="tooltip"
                        data-bs-placement="left"
                        data-bs-title="26 de enero de 2023 a las 02:21"
                    >
                    ${message.content}
                    </small>
                </div>
                `);
            });
            $('#box-div').removeClass('d-none');

            const chats = await findUserChats();
            $('#chat-drawer').empty().append(chats);
            messageBox.scrollTo({
                left: 0,
                top: messageBox.scrollHeight
            });

            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        
        }
    })
    .data('ui-autocomplete')._renderItem = function(ul, item) {
        return $('<li></li>')
            .data('item.autocomplete', item)
            .append(item.label)
            .appendTo(ul);
    };
});