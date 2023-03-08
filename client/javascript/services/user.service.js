import axios from 'axios';

export const createUser = async (user) => {
    try {
        const configuration = {
            method: 'POST',
            url: '/api/v1/users',
            headers: { 
                'Content-Type': 'application/json'
            },
            data : JSON.stringify(user)
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        console.log(exception);
    }
    return null;
}

export const updateUser = async (user) => {
    const response = await fetch('/api/v1/users', {
        method: 'PUT',
        body: user
    });
    const json = await response.json();
    return json;
}

export const updateUserPassword = async (user) => {
    return { ok: true };
}

export const loginUser = async (auth) => {
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
    catch (exception) {
        console.log(exception);
    }
    return null;
}

export const logoutUser = async (auth) => {
    const response = await fetch('/api/v1/auth', {
        method: 'DELETE'
    });
    const json = await response.json();
    return json;
}