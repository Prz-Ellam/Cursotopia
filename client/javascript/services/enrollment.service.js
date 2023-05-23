import axios from 'axios';

export default class EnrollmentService {
    static create = async (enrollment) => {
        try {
            const configuration = {
                method: 'POST',
                url: '/api/v1/enrollments',
                headers: { 
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(enrollment)
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data;
        }
    }

    static pay = async (enrollment) => {
        try {
            const configuration = {
                method: 'POST',
                url: '/api/v1/enrollments/pay',
                headers: { 
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(enrollment)
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data;
        }
    }
}
