import $ from 'jquery';
import 'jquery-validation';
import ReviewService, { showMoreCommentsService, deleteReviewService } from "../services/review.service";
import { getOneUserService } from "../services/user.service";
import { createReview, showMoreReviews } from '../views/review.view';
import Swal from 'sweetalert2';
import { showErrorMessage } from '../utilities/show-error-message';
import { Toast } from '../utilities/toast';

let currentPage = 1;
const pageSize = 10;

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
        rate: formData.get('rate'),
        courseId
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

    $('#review-section').empty();
    const totalCourses = await ReviewService.courseTotal(courseId);
    REVIEWS_TOTAL_PAGES = Math.ceil(totalCourses / pageSize);
    showMoreComments2(courseId, 1, currentPage * pageSize);
    console.log(currentPage);
    /*

    let userId = Number.parseInt(document.getElementById('userId').value);

    if(!Number.isInteger(userId)){

        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;

    }

    const user = await getOneUserService(userId);

    if (user) {
        const reviewView = {
            image: user['profilePicture'],
            username: user['name']+' '+user['lastName'],
            message: document.getElementById('message-box').value,
            rate: Number.parseInt(document.getElementById('rate').value)
        }
        
        createReview(reviewView);
    }
    else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }
    */

    $(this)[0].reset();
    $('.rate-star').removeClass('bxs-star').addClass('bx-star');
}

export const showMoreComments = async function(pageNum, courseId) {
    currentPage++;
    //courseId=new URLSearchParams(window.location.search).get('id') || '';
    const pageSize = 1;
    const response = await showMoreCommentsService(courseId,pageNum,pageSize);
    if (response?.status) {
        var userId = $("#show-more-comments").data('user-id');
        var userRole = $("#show-more-comments").data('user-rol');
        const reviews = response.reviews;
        reviews.forEach(review => {
            showMoreReviews(review, userId, userRole);
        });
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }

}

export const showMoreComments2 = async function(courseId, pageNum, pageSize) {
    //courseId=new URLSearchParams(window.location.search).get('id') || '';
    const response = await showMoreCommentsService(courseId,pageNum,pageSize);
    if (response?.status) {
        var userId = $("#show-more-comments").data('user-id');
        var userRole = $("#show-more-comments").data('user-rol');
        const reviews = response.reviews;
        reviews.forEach(review => {
            showMoreReviews(review, userId, userRole);
        });
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }
}

export const deleteReview = async function(reviewId) {
    
    const response = await deleteReviewService(reviewId);
    if (response?.status) {
        Toast.fire({
            icon: 'success',
            title: 'La reseña ha sido eliminada con éxito'
        });
        currentPage = 1;
        $('#review-section').empty();
        const courseId=new URLSearchParams(window.location.search).get('id') || '';
        const totalCourses = await ReviewService.courseTotal(courseId);
        REVIEWS_TOTAL_PAGES = Math.ceil(totalCourses / pageSize);
        const responseReviews = await showMoreCommentsService(courseId,1,1*currentPage);
        if (responseReviews?.status) {
            var userId = $("#show-more-comments").data('user-id');
            var userRole = $("#show-more-comments").data('user-rol');
            const reviews = responseReviews.reviews;
            console.log(reviews);
            reviews.forEach(review => {
                showMoreReviews(review, userId, userRole);
            });
        }
    }else{
        await Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: "Algo salió mal",
            confirmButtonColor: "#de4f54",
            background: "#EFEFEF",
            customClass: {
                confirmButton: 'btn btn-danger shadow-none rounded-pill'
            },
        });
        return;
    }

}