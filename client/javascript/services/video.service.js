import axios from 'axios';

export const mainService = async(method, url, contentType, data) => {
    try {
        const configuration = {
            method: method,
            url: url,
            headers: { 
                'Content-Type': contentType
            },
            data : data
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        console.log(exception);
        return exception.response.data;
    }
    return null;
}

export const createVideoService = async (video) => {
    return await mainService('POST', 
        '/api/v1/videos', 
        'multipart/form-data', 
        video
    );
}

export const updateVideo = async (video) => {
    return { ok: true };
}

export const deleteVideo = async (video) => {
    return { ok: true };
}