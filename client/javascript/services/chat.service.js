//import axios from 'axios';
import { mainService } from './video.service';

export default class ChatService {
    static findOne = async (chat) => {
        return await mainService('POST', '/api/v1/chats/find', 'application/json', chat);
    }

    static findAllByUser = async () => {
        return await mainService('GET', '/api/v1/users/chats', 'application/json', {});
    }
}
