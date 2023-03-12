import axios from 'axios';

export const createCategory = async (category) => {
    try {
        const configuration = {
            method: 'POST',
            url: `/api/v1/categories`,
            headers: {
                'Content-Type': 'application/json'
            },
            data : JSON.stringify(category)
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        console.log(exception);
    }
    return null;
}

export const updateCategory = async (category) => {
    return { ok: true };
}

export const deleteCategory = async (category) => {
    return { ok: true };
}

export const getAllCategories = async (category) => {
    
}