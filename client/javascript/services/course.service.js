import axios from 'axios';
import { mainService } from './video.service';

export default class CourseService {
    static create = async (course) => {
        return await mainService('POST', '/api/v1/courses', 'multipart/form-data', course);
    }

    static update = async (id, course) => {
        return await mainService('PUT', `/api/v1/courses/${ id }`, 'application/json', course);
    }

    static delete = async (id) => {
        return await mainService('DELETE', `/api/v1/courses/${id}`, 'application/json', {});
    }

    static approve = async (approve, id) => {
        return await mainService('PUT', `/api/v1/courses/${id}/approve`, 'application/json', approve);
    }

    static findnotApproved = async () => {
        return await mainService('GET', `/api/v1/courses`, 'application/json');
    }
    
}


export const courseConfirmService = async (courseId) => {
    return await mainService('PUT', `/api/v1/courses/${courseId}/confirm`, 'application/json', {});
}

export const approveCourseService = async (courseId) => {
    return await mainService('PUT', `/api/v1/courses/${courseId}/approve`, 'application/json', {"approve":true});
}

export const denyCourseService = async (courseId) => {
    return await mainService('PUT', `/api/v1/courses/${courseId}/deny`, 'application/json');
}
