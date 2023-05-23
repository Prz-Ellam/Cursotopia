import axios from 'axios';

export default class MessageService {
    static create = async (message, chatId) => {
        try {
            const configuration = {
                method: 'POST',
                url: `/api/v1/chats/${ chatId }/messages`,
                headers: { 
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(message)
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data
        }
    }

    static findAllByChat = async (chatId) => {
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
}
