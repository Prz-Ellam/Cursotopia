import $ from 'jquery';
import 'jquery-validation';
import { createReviewService } from "../services/review.service";
import { createReview } from '../views/review.view';

export const submitReview = async function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const formData = new FormData(this);
    const review = {
        message: formData.get('message'),
        rate: formData.get('rate'),
        courseId: new URLSearchParams(window.location.search).get('id') || ''
    };
    const response = await createReviewService(review);
    if (response?.status) {
        
    }

    const reviewView = {
        image: '../client/assets/images/logo.png',
        username: 'Test',
        message: document.getElementById('message-box').value,
        rate: document.getElementById('rate').value
    }
    
    createReview(reviewView);
}