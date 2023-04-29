import axios from 'axios';
import { mainService } from './video.service';

class CourseService {
    static create = async (course) => {
        return await mainService('POST', '/api/v1/courses', 'multipart/form-data', course);
    }

    static delete = async (id) => {
        return await mainService('DELETE', `/api/v1/courses/${id}`, 'application/json', {});
    }

    static approve = async (approve, id) => {
        return await mainService('PUT', `/api/v1/courses/${id}/approve`, 'application/json', approve);
    }
}

export default CourseService;

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