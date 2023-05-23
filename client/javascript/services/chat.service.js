import axios from 'axios';

export default class ChatService {
    static findOne = async (chat) => {
        try {
            const configuration = {
                method: 'POST',
                url: '/api/v1/chats/find',
                headers: { 
                    'Content-Type': 'application/json'
                },
                data : JSON.stringify(chat)
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data;
        }
    }

    static findAllByUser = async () => {
        try {
            const configuration = {
                method: 'GET',
                url: '/api/v1/users/chats',
                headers: { 
                    'Content-Type': 'application/json'
                }
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data;
        }
    }
}
