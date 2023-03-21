import axios from 'axios';
import { mainService } from './video.service';

export const createDocumentService = async (document) => {
    return await mainService('POST', 
        '/api/v1/documents', 
        'multipart/form-data', 
        document
    );
}
