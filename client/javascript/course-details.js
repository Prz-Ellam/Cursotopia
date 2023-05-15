import $ from 'jquery';
import 'jquery-validation';
import 'bootstrap';
import { Tooltip } from 'bootstrap';
import { enroll } from './controllers/payment-method.controller';
import { submitReview, deleteReview, clickMoreComments } from './controllers/review.controller';
import createReviewValidator from './validators/review-create.validator';

$(async () => {
    $('#enroll').on('click', enroll);

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))

    const rateStars = document.getElementsByClassName('rate-star');
    const arrayRateStars = Array.from(rateStars);
    arrayRateStars.forEach(rateStar => {
        rateStar.addEventListener('click', (event) => {    
            const starNumber = event.target.getAttribute('star');
            arrayRateStars.forEach((rateStar, i) => {
                if(starNumber > i) {
                    rateStar.classList.add('bxs-star');
                    rateStar.classList.remove('bx-star');
                }
                else {
                    rateStar.classList.remove('bxs-star');
                    rateStar.classList.add('bx-star');
                }
            });
            const rate = document.getElementById('rate');
            rate.value = parseInt(starNumber);
            $('#rate').valid();
        });
    });

    $('#create-review-form').validate(createReviewValidator);
    $('#create-review-form').on('submit', submitReview);

    $('#show-more-comments').on('click', clickMoreComments);

    $(document).on('click', '.delete-review', async function() {
        const reviewId = $(this).attr('data-id');
        await deleteReview(reviewId);
    });
});
