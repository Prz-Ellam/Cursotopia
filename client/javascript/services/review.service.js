import axios from 'axios';
import { mainService } from './video.service';

export default class ReviewService {
    static create = async (review) => {
        return await mainService('POST', '/api/v1/reviews', 'application/json', review);
    };
}

export const createReviewService = async (review) => {
    return await mainService('POST', '/api/v1/reviews', 'application/json', review);
};

export const showMoreCommentsService = async (courseId, pageNum, pageSize) => {
    return await mainService('GET', `/api/v1/reviews/${courseId}/${pageNum}/${pageSize}`);
};



export const updateReview = async () => {
    return { ok: true };
};

export const deleteReviewService = async (reviewId) => {
    return await mainService('DELETE', `/api/v1/reviews/${reviewId}`);
};

export const findAllCourseReviews = async () => {
    return { ok: true };
}