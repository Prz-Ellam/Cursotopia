import axios from 'axios';
import { mainService } from './video.service';

export const createMessageService = async (message, chatId) => {
    return await mainService('POST', `/api/v1/chats/${ chatId }/messages`, 'application/json', message);
};

export const getAllChatMessageService = async (chatId) => {
    try {
        const configuration = {
            method: 'GET',
            url: `/api/v1/chats/${ chatId }/messages`,
            headers: { 
                'Content-Type': 'application/json'
            }
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        return exception.response.data
    }
}