import axios from 'axios';
import { mainService } from './video.service';

export default class LessonService {
    static create = async (lesson) => {
        return await mainService('POST', '/api/v1/lessons', 'multipart/form-data', lesson);       
    }

    static update = async (lesson, id) => {
        return await mainService('PUT', `/api/v1/lessons/${id}`, 'application/json', lesson);
    }

    static delete = async (id) => {
        return await mainService('DELETE', `/api/v1/lessons/${id}`, 'application/json', {});
    }

    static findById = async (id) => {
        return await mainService('GET', `/api/v1/lessons/${id}`, 'application/json', {});
    }

    static complete = async (id) => {
        return await mainService('PUT', `/api/v1/lessons/${id}/complete`, 'application/json', {});
    }

    static visit = async (id) => {
        return await mainService('PUT', `/api/v1/lessons/${id}/visit`, 'application/json', {});
    }
}
