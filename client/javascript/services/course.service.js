import axios from 'axios';
import { mainService } from './video.service';

export const createCourseService = async (course) => {
    return await mainService('POST', '/api/v1/courses', 'application/json', course);
}

export const updateCourse = async () => {
    
}

export const deleteCourse = (course) => {

}