import $ from './jquery-global';
import 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'
import { Tooltip } from 'bootstrap';
import { loadMessages, sendMessage } from './controllers/chat.controller';
import ChatService from './services/chat.service';
import UserService from './services/user.service';

$(async () => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))

    $('#message').on('keydown', async function(event) {
        if (event.key === 'Enter') {
            await sendMessage();
            const chats = await ChatService.findAllByUser();
            $('#chat-drawer').empty().append(chats);
        }
    });

    $('#send-message').on('click', async function() {
        await sendMessage();
        const chats = await ChatService.findAllByUser();
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
        loadMessages(id);
    });

    $("#search-users").autocomplete({
        delay: 100,
        source: async function(request, response) {
            const data = await UserService.findAll(request.term);
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

            const response = await ChatService.findOne({ userTwo: ui.item.value });
            console.log(response);
            $('#actual-chat-id').val(response.chatId);

            $('.actual-chat-user-image').attr('src', `/api/v1/images/${ response.user.profilePicture }`);
            $('.actual-chat-user-name').text(`${ response.user.name } ${ response.user.lastName }`);
        
            loadMessages(response.chatId);
        }
    })
    .data('ui-autocomplete')._renderItem = function(ul, item) {
        return $('<li></li>')
            .data('item.autocomplete', item)
            .append(item.label)
            .appendTo(ul);
    };
});