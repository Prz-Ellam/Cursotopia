import axios from 'axios';

export const createUserService = async (user) => {
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
        return exception.response.data;
    }
}

export const updateUserService = async (user, id) => {
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

export const updateUserPasswordService = async (user, id) => {
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
    catch (ex) {
        return ex.response.data;
    }
}

export const logoutUser = async (auth) => {
    const response = await fetch('/api/v1/auth', {
        method: 'DELETE'
    });
    const json = await response.json();
    return json;
}

export const getAllUsersService = async (name) => {
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
};

export const getAllInstructorsUsersService = async (name) => {
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
};

export const getOneUserService = async (id) => {
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
        console.log(exception);
    }
    return null;    
};