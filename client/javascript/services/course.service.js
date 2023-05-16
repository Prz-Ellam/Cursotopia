import axios from 'axios';
import { mainService } from './video.service';

export default class CourseService {
    static create = async (course) => {
        try {
            const configuration = {
                method: 'POST',
                url: '/api/v1/courses',
                headers: { 
                    'Content-Type': 'multipart/form-data'
                },
                data : course
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data;
        }
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

    static confirm = async (courseId) => {
        return await mainService('PUT', `/api/v1/courses/${courseId}/confirm`, 'application/json', {});
    }
    
    static approve = async (courseId) => {
        return await mainService('PUT', `/api/v1/courses/${courseId}/approve`, 'application/json', {"approve":true});
    }

    static deny = async (courseId) => {
        return await mainService('PUT', `/api/v1/courses/${courseId}/deny`, 'application/json');
    }
}
