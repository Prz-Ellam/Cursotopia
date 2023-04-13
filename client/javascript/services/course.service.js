import axios from 'axios';
import { mainService } from './video.service';

export const createCourseService = async (course) => {
    return await mainService('POST', '/api/v1/courses', 'application/json', course);
}

export const courseConfirmService = async (courseId) => {
    return await mainService('PUT', `/api/v1/courses/${courseId}/confirm`, 'application/json', {});
}

export const updateCourse = async () => {
    
}

export const deleteCourse = (course) => {

}