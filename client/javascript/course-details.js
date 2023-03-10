import $ from 'jquery';
import 'jquery-validation';
import createReviewValidator from './validators/create-review.validator';
import { createReview } from './views/review.view';

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

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
$('#create-review-form').on('submit', function(event) {
    event.preventDefault();

    const validations = $(this).valid();
    if (!validations) {
        return;
    }

    const review = {
        image: '../client/assets/images/logo.png',
        username: 'Test',
        message: document.getElementById('message-box').value,
        rate: document.getElementById('rate').value
    }
    
    createReview(review);
});