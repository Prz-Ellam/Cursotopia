import axios from 'axios';

export default class UserService {
    static create = async (user) => {
        try {
            const configuration = {
                method: 'POST',
                url: '/api/v1/users',
                headers: { 
                    'Content-Type': 'multipart/form-data'
                },
                data : user
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data;
        }
    }

    static update = async (user, id) => {
        try {
            const configuration = {
                method: 'PATCH',
                url: `/api/v1/users/${id}`,
                headers: {
                    'Content-Type': 'application/json'
                },
                data : JSON.stringify(user)
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data;
        }
    }

    static updatePassword = async (user, id) => {
        try {
            const configuration = {
                method: 'PATCH',
                url: `/api/v1/users/${id}/password`,
                headers: {
                    'Content-Type': 'application/json'
                },
                data : JSON.stringify(user)
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data;
        }
    }

    static login = async (auth) => {
        try {
            const configuration = {
                method: 'POST',
                url: '/api/v1/auth',
                headers: { 
                    'Content-Type': 'application/json'
                },
                data : JSON.stringify(auth)
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (ex) {
            return ex.response.data;
        }
    }

    static logout = async (auth) => {
        const response = await fetch('/api/v1/auth', {
            method: 'DELETE'
        });
        const json = await response.json();
        return json;
    }

    static findAll = async (name) => {
        try {
            const configuration = {
                method: 'GET',
                url: `/api/v1/users?name=${name}`,
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

    static findAllInstructors = async (name) => {
        try {
            const configuration = {
                method: 'GET',
                url: `/api/v1/users/instructors?name=${name}`,
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

    static findOne = async (id) => {
        try {
            const configuration = {
                method: 'GET',
                url: `/api/v1/users/${ id }`,
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
    };

    static block = async (id) => {
        try {
            const configuration = {
                method: 'PUT',
                url: `/api/v1/users/${id}/block`,
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
    };

    static unblock = async (id) => {
        try {
            const configuration = {
                method: 'PUT',
                url: `/api/v1/users/${id}/unblock`,
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

    static findBlocked = async () => {
        try {
            const configuration = {
                method: 'GET',
                url: `/api/v1/users/blocked`,
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

    static findUnblocked = async () => {
        try {
            const configuration = {
                method: 'GET',
                url: `/api/v1/users/unblocked`,
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
    };
}
