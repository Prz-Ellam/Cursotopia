import $ from 'jquery';
import 'jquery-validation';
import { createReviewService, showMoreCommentsService, deleteReviewService } from "../services/review.service";
import { getOneUserService } from "../services/user.service";
import { createReview, showMoreReviews } from '../views/review.view';
import Swal from 'sweetalert2';
import { Toast } from "../utilities/toast";
import { showErrorMessage } from '../utilities/show-error-message';

export const submitReview = async function(event) {
    event.preventDefault();

    const isFormValid = $(this).valid();
    if (!isFormValid) {
        return;
    }

    const formData = new FormData(this);
    const review = {
        message: formData.get('message'),
        rate: formData.get('rate'),
        courseId: new URLSearchParams(window.location.search).get('id') || ''
    };

    const response = await createReviewService(review);
    if (!response?.status) {
        showErrorMessage(response);
        return;
    }

    let userId = parseInt(document.getElementById('userId').value);

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

    if(user){
        const reviewView = {
            image: user['profilePicture'],
            username: user['name']+' '+user['lastName'],
            message: document.getElementById('message-box').value,
            rate: document.getElementById('rate').value
        }
        
        createReview(reviewView);

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

let currentPage = 1;

export const showMoreComments = async function(pageNum, courseId) {
    currentPage++;
    courseId=new URLSearchParams(window.location.search).get('id') || '';
    const pageSize = 10;
    const response = await showMoreCommentsService(courseId,pageNum,pageSize);
    if (response?.status) {
        var userId = $("#show-more-comments").data('user-id');
        var userRole = $("#show-more-comments").data('user-rol');
        const reviews = response.reviews;
        reviews.forEach(review => {
            showMoreReviews(review, userId, userRole);
        });
    }

}

export const deleteReview = async function(reviewId) {
    
    const response = await deleteReviewService(reviewId);
    if (response?.status) {
        $('#review-section').empty();
        const courseId=new URLSearchParams(window.location.search).get('id') || '';
        const responseReviews = await showMoreCommentsService(courseId,1,10*currentPage);
        if (responseReviews?.status) {
            var userId = $("#show-more-comments").data('user-id');
            var userRole = $("#show-more-comments").data('user-rol');
            const reviews = responseReviews.reviews;
            console.log(reviews);
            reviews.forEach(review => {
                showMoreReviews(review, userId, userRole);
            });
        }
    }

}