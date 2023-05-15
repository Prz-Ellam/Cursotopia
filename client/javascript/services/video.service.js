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
        //console.log(exception);
        return exception.response.data;
    }
}

export default class VideoService {
    static update = async (id, video) => {
        return await mainService('POST', 
            `/api/v1/videos/${ id }`, 
            'multipart/form-data', 
            video
        );
    };

    static delete = async (id, video) => {
        return await mainService('DELETE', 
            `/api/v1/videos/${ id }`, 
            'application/json', 
            video
        );
    };

    static putLessonVideo = async (lessonId, video) => {
        return await mainService('POST', 
        `/api/v1/lessons/${ lessonId }/videos`, 
        'multipart/form-data', 
        video);
    }
}
