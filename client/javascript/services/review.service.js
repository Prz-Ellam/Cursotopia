import axios from 'axios';
import { mainService } from './video.service';

export const createReviewService = async (review) => {
    return await mainService('POST', '/api/v1/reviews', 'application/json', review);
};

export const updateReview = async () => {
    return { ok: true };
};

export const deleteReview = async () => {
    return { ok: true };
};

export const findAllCourseReviews = async () => {
    return { ok: true };
}