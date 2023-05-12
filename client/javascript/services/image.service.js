import axios from 'axios';

export const createImage = async (image) => {
    try {
        const configuration = {
            method: 'POST',
            url: '/api/v1/images',
            headers: { 
                'Content-Type': 'multipart/form-data'
            },
            data : image
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        return exception.response.data
    }
}

export const updateImageService = async (image, id) => {
    try {
        const configuration = {
            method: 'PUT',
            url: `/api/v1/images/${ id }`,
            headers: { 
                'Content-Type': 'multipart/form-data'
            },
            data : image
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        return exception.response.data
    }
}