import axios from 'axios';
import { mainService } from './video.service';

export default class ReviewService {
    static create = async (review) => {
        return await mainService('POST', '/api/v1/reviews', 'application/json', review);
    };

    static delete = async (reviewId) => {
        return await mainService('DELETE', `/api/v1/reviews/${reviewId}`);
    };

    static showMoreComments = async (courseId, pageNum, pageSize) => {
        return await mainService('GET', `/api/v1/reviews/${courseId}/${pageNum}/${pageSize}`);
    };

    static courseTotal = async (courseId) => {
        return await mainService('GET', `/api/v1/courses/${courseId}/reviews/total`, 'application/json', {});
    }
}

export const createReviewService = async (review) => {
    return await mainService('POST', '/api/v1/reviews', 'application/json', review);
};

export const showMoreCommentsService = async (courseId, pageNum, pageSize) => {
    return await mainService('GET', `/api/v1/reviews/${courseId}/${pageNum}/${pageSize}`);
};


export const deleteReviewService = async (reviewId) => {
    return await mainService('DELETE', `/api/v1/reviews/${reviewId}`);
};

