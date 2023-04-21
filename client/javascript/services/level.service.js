import axios from 'axios';
import { mainService } from './video.service';

class LevelService {
    static create = async (level) => {
        return await mainService('POST', '/api/v1/levels', 'application/json', level);
    }

    static update = async (level, id) => {
        return await mainService('PUT', `/api/v1/levels/${id}`, 'application/json', level);
    }

    static findById = async (id) => {
        return await mainService('GET', `/api/v1/levels/${id}`, 'application/json', {});
    }
}

export default LevelService;

export const findByIdService = async (id) => {
    return await mainService('GET', `/api/v1/levels/${id}`, 'application/json', {});
}

export const createLevelService = async (level) => {
    return await mainService('POST', '/api/v1/levels', 'application/json', level);
}

export const updateLevel = async () => {

}

export const deleteLevel = async () => {
    
}