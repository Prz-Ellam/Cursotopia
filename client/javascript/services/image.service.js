import axios from 'axios';
import { mainService } from './video.service';

export default class ImageService {
    static putLessonImage = async (lessonId, image) => {
        return await mainService('POST', 
        `/api/v1/lessons/${ lessonId }/images`, 
        'multipart/form-data', 
        image);
    }

    static update = async (image, id) => {
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

    static delete = async (id) => {
        return await mainService('DELETE', 
            `/api/v1/images/${ id }`, 
            'application/json', 
            {}
        );
    };
}
