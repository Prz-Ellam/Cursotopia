import axios from 'axios';
import { mainService } from './video.service';

export default class LessonService {
    static create = async (lesson) => {
        return await mainService('POST', '/api/v1/lessons', 'application/json', lesson);       
    }

    static update = async (lesson, id) => {
        return await mainService('PUT', `/api/v1/lessons/${id}`, 'application/json', lesson);
    }

    static complete = async (id) => {
        return await mainService('PUT', `/api/v1/lessons/${id}/complete`, 'application/json', {});
    }

    static visit = async (id) => {
        return await mainService('PUT', `/api/v1/lessons/${id}/visit`, 'application/json', {});
    }
}

export const findByIdService = async (id) => {
    return await mainService('GET', `/api/v1/lessons/${id}`, 'application/json', {});
}

export const createLessonService = async (lesson) => {
    return await mainService('POST', '/api/v1/lessons', 'application/json', lesson);
}

export const updateLesson = async () => {

}

export const deleteLesson = async () => {
    
}