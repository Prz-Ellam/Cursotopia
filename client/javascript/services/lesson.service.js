import axios from 'axios';
import { mainService } from './video.service';

export const createLessonService = async (lesson) => {
    return await mainService('POST', '/api/v1/lessons', 'application/json', lesson);
}

export const updateLesson = async () => {

}

export const deleteLesson = async () => {
    
}