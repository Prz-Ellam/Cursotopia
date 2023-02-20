import $ from 'jquery';
import { createReview } from './views/review.view';

$('#create-review-form').on('submit', function(event) {
    event.preventDefault();

    const review = {
        message: 'message'
    }
    
    createReview(review);
});