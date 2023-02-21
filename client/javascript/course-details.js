import $ from 'jquery';
import { createReview } from './views/review.view';

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
        rate.value = starNumber + 1;
    });
});

$('#create-review-form').on('submit', function(event) {
    event.preventDefault();

    const review = {
        message: 'message'
    }
    
    createReview(review);
});