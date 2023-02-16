export const createUser = async (user) => {
    const response = await fetch('/api/v1/users', {
        method: 'POST',
        body: user
    });
    const json = await response.json();
    return json;
}

export const updateUser = async (user) => {
    const response = await fetch('/api/v1/users', {
        method: 'PUT',
        body: user
    });
    const json = await response.json();
    return json;
}

export const loginUser = async (auth) => {
    const response = await fetch('/api/v1/auth', {
        method: 'POST',
        body: auth
    });
    const json = await response.json();
    return json;
}

export const logoutUser = async (auth) => {
    const response = await fetch('/api/v1/auth', {
        method: 'DELETE'
    });
    const json = await response.json();
    return json;
}