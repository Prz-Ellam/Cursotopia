import $ from 'jquery';
import 'bootstrap';
import { blockUser, unblockUser } from './controllers/user.controller';

$(() => {
    $(document).on('click', '.block-btn', async function() {
        const userId = $(this).attr('id');
        await blockUser(userId);
    });

    $(document).on('click', '.unblock-btn', async function() {
        const userId = $(this).attr('id');
        await unblockUser(userId);
    });
});