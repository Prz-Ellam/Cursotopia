import $ from 'jquery';
import 'jquery-validation';
import { enroll } from './controllers/payment-method.controller';
import { submitReview, showMoreComments, deleteReview } from './controllers/review.controller';
import createReviewValidator from './validators/create-review.validator';


$(() => {
    $('#enroll').on('click', enroll);

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
    $('#create-review-form').on('submit', submitReview);

    var currentPage = 1;

    $('#show-more-comments').on('click', function() {
        const courseId = new URLSearchParams(window.location.search).get('id') ?? -1;
        currentPage++; // or any other value you want to pass as a parameter
        showMoreComments(currentPage, courseId);
        if (currentPage >= REVIEWS_TOTAL_PAGES) {
            $('#show-more-comments').addClass('d-none');
        }
    });

    $(document).on('click', '.delete-review', function() {
        const reviewId = $(this).attr('reviewId');
        deleteReview(reviewId);
    });

});

