import $ from 'jquery';
import 'bootstrap';
import { blockUser, unblockUser } from './controllers/user.controller';

$(async () => {
    $(document).on('click', '.block-btn', async function() {
        const userId = $(this).attr('data-id');
        await blockUser(userId);
    });

    $(document).on('click', '.unblock-btn', async function() {
        const userId = $(this).attr('data-id');
        await unblockUser(userId);
    });
});