//import axios from 'axios';
import { mainService } from './video.service';

export const findChatService = async (chat) => {
    return await mainService('POST', '/api/v1/chats/find', 'application/json', chat);
}