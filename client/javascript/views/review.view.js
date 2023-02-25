import $ from 'jquery';

export const createReview = (review) => {
    const html = `
        <div class="card-body p-4">
          <div class="d-flex flex-start">
            <img class="rounded-circle shadow-1-strong me-3"
              src="${review.image}" alt="avatar" width="60" height="60">
            <div>
              <a class="fw-bold mb-1">${ review.username }</a>
              <div class="d-flex align-items-center mb-1 gap-2">
                <small class="mb-0">${ new Date() }</small>
                <span>
                  <i class="bx ${ review.rate >= 1 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 2 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 3 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 4 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 5 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                </span>
              </div>
              <p class="mb-0">${ review.message }</p>
            </div>
          </div>
        </div>
		<hr>
    `;
	$('#review-section').prepend(html);
}