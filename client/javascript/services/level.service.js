import axios from 'axios';
import { mainService } from './video.service';

export default class LevelService {
    static create = async (level) => {
        return await mainService('POST', '/api/v1/levels', 'application/json', level);
    }

    static update = async (level, id) => {
        return await mainService('PUT', `/api/v1/levels/${id}`, 'application/json', level);
    }

    static delete = async (id) => {
        return await mainService('DELETE', `/api/v1/levels/${id}`, 'application/json', {});
    }

    static findById = async (id) => {
        return await mainService('GET', `/api/v1/levels/${id}`, 'application/json', {});
    }
}
