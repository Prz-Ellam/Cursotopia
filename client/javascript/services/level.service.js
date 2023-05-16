import axios from 'axios';

export default class LevelService {
    static create = async (level) => {
        try {
            const configuration = {
                method: 'POST',
                url: '/api/v1/levels',
                headers: {
                    'Content-Type': 'application/json'
                },
                data : JSON.stringify(level)
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data;
        }
    }

    static update = async (level, id) => {
        try {
            const configuration = {
                method: 'PUT',
                url: `/api/v1/levels/${id}`,
                headers: {
                    'Content-Type': 'application/json'
                },
                data : JSON.stringify(level)
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data;
        }
    }

    static delete = async (id) => {
        try {
            const configuration = {
                method: 'DELETE',
                url: `/api/v1/levels/${id}`,
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

    static findById = async (id) => {
        try {
            const configuration = {
                method: 'GET',
                url: `/api/v1/levels/${id}`,
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
