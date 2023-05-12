import $ from 'jquery';
import 'jquery-validation';
import ReviewService, { showMoreCommentsService, deleteReviewService } from "../services/review.service";
import { createReview, showMoreReviews } from '../views/review.view';
import Swal from 'sweetalert2';
import { showErrorMessage } from '../utilities/show-error-message';
import { Toast } from '../utilities/toast';

let currentPage = 1;
const pageSize = 5;

export const submitReview = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    const courseId = new URLSearchParams(window.location.search).get('id') ?? '';
    const formData = new FormData(this);
    const review = {
        message: formData.get('message'),
        rate: +formData.get('rate'),
        courseId: +courseId
    };

    $('#review-create-btn').prop('disabled', true);
    $('#review-create-spinner').removeClass('d-none');

    const response = await ReviewService.create(review);

    $('#review-create-spinner').addClass('d-none');
    $('#review-create-btn').prop('disabled', false);

    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    Toast.fire({
        icon: 'success',
        title: 'La reseña ha sido añadida con éxito'
    });

    const totalCourses = await ReviewService.courseTotal(courseId);
    REVIEWS_TOTAL_PAGES = Math.ceil(totalCourses / pageSize);
    
    showMoreComments(courseId, 1, currentPage * pageSize, true);
    if (currentPage >= REVIEWS_TOTAL_PAGES) {
        $('#show-more-comments').addClass('d-none');
    }
    else {
        $('#show-more-comments').removeClass('d-none');
    }
    
    $(this)[0].reset();
    $('.rate-star').removeClass('bxs-star').addClass('bx-star');
}

export const clickMoreComments = async function(event) {
    const courseId = new URLSearchParams(window.location.search).get('id') ?? -1;
    currentPage++;
    await showMoreComments(courseId, currentPage, pageSize);
    if (currentPage >= REVIEWS_TOTAL_PAGES) {
        $('#show-more-comments').addClass('d-none');
    }
    else {
        $('#show-more-comments').removeClass('d-none');
    }
}

export const showMoreComments = async function(courseId, pageNum, pageSize, empty = false) {
    const response = await showMoreCommentsService(courseId, pageNum, pageSize);
    if (!response?.status) {
        showErrorMessage(response);
        return;
    }
    
    const userId = $("#show-more-comments").data('user-id');
    const userRole = $("#show-more-comments").data('user-rol');
    const reviews = response.reviews;

    if (empty) {
        $('#review-section').empty();
    }

    reviews.forEach(review => {
        showMoreReviews(review, userId, userRole);
    });
}

export const deleteReview = async function(reviewId) { 
    const response = await deleteReviewService(reviewId);
    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    Toast.fire({
        icon: 'success',
        title: 'La reseña ha sido eliminada con éxito'
    });

    const courseId = new URLSearchParams(window.location.search).get('id') ?? -1;

    const totalCourses = await ReviewService.courseTotal(courseId);
    REVIEWS_TOTAL_PAGES = Math.ceil(totalCourses / pageSize);

    showMoreComments(courseId, 1, currentPage * pageSize, true);

    if (currentPage >= REVIEWS_TOTAL_PAGES) {
        $('#show-more-comments').addClass('d-none');
    }
    else {
        $('#show-more-comments').removeClass('d-none');
    }
}