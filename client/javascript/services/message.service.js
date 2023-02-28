const createMessage = async (message) => {
    const response = await fetch('/api/v1/messages', {
        method: 'POST',
        body: message
    });
    const json = await response.json();
    return json;
}

const updateMessage = async (message) => {
    const response = await fetch('/api/v1/messages', {
        method: 'PUT',
        body: message
    });
    const json = await response.json();
    return json;
}

const deleteMessage = async (message) => {
    const response = await fetch('/api/v1/messages', {
        method: 'DELETE',
        body: message
    });
    const json = await response.json();
    return json;
}

const getAllByChat = async () => {
    const response = await fetch('/api/v1/messages', {
        method: 'GET'
    });
    const json = await response.json();
    return json;
}