import axios from 'axios';
import { mainService } from './video.service';

export const createEnrollmentService = async (enrollment) => {
    return await mainService('POST', 
        '/api/v1/enrollments', 
        'application/json', 
        enrollment
    );
}

export const payEnrollmentService = async (enrollment) => {
    return await mainService('POST', 
        '/api/v1/enrollments/pay', 
        'application/json', 
        enrollment
    );
}