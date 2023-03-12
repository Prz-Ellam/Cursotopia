import axios from 'axios';
import { mainService } from './video.service';

export const createLevelService = async (level) => {
    return await mainService('POST', '/api/v1/levels', 'application/json', level);
}

export const updateLevel = async () => {

}

export const deleteLevel = async () => {
    
}