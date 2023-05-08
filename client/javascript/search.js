import AOS from 'aos';
import { getAllInstructorsUsersService } from './services/user.service';

$(() => {
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });

    $('#instructors').on('input', function(event) {
        $('#instructor').val('');
    });

    $('#instructors').autocomplete({
        delay: 1,
        source: async function(request, response) {
            const data = await getAllInstructorsUsersService(request.term);
            response($.map(data, function(object) {
                return {
                    label: `<div><img src="api/v1/images/${object.profilePicture}" style="object-fit: cover" class="rounded-circle" height="50" width="50">&nbsp;&nbsp;&nbsp; ` + object.name + ' ' + object.lastName + ' </div>',
                    name: `${object.name} ${object.lastName}`,
                    value: `${object.name} ${object.lastName}`,
                    id: object.id
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
            $('#instructor').val(ui.item.id);
            
        }
    })
    .data('ui-autocomplete')._renderItem = function(ul, item) {
        return $('<li></li>')
            .data("item.autocomplete", item)
            .append(item.label)
            .appendTo(ul);
    };
});