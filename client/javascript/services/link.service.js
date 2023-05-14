import axios from 'axios';
import { mainService } from './video.service';

export default class LinkService {
    static create = async (link) => {
        return await mainService('POST', '/api/v1/links', 'application/json', linj);
    }

    static update = async (link, id) => {
        return await mainService('PUT', `/api/v1/links/${id}`, 'application/json', link);
    }

    static delete = async (id) => {
        return await mainService('DELETE', `/api/v1/links/${id}`, 'application/json', {});
    }

    static findById = async (id) => {
        return await mainService('GET', `/api/v1/links/${id}`, 'application/json', {});
    }

    static putLessonLink = async (lessonId, link) => {
        return await mainService('POST', 
        `/api/v1/lessons/${ lessonId }/links`, 
        'application/json', 
        link);
    }
}