import axios from 'axios';
import { mainService } from './video.service';

export default class DocumentService {
    static update = async (id, document) => {
        return await mainService('POST', 
            `/api/v1/documents/${ id }`, 
            'multipart/form-data', 
            document
        );
    };

    static delete = async (id) => {
        return await mainService('DELETE', 
            `/api/v1/documents/${ id }`, 
            'application/json', 
            {}
        );
    };

    static putLessonDocument = async (lessonId, document) => {
        return await mainService('POST', 
        `/api/v1/lessons/${ lessonId }/documents`, 
        'multipart/form-data', 
        document
        );
    }
}

