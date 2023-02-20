import $ from 'jquery';

export const createReview = (review) => {
    const html = `
        <div class="card-body p-4">
          <div class="d-flex flex-start">
            <img class="rounded-circle shadow-1-strong me-3"
              src="${review.message}" alt="avatar" width="60" height="60">
            <div>
              <a class="fw-bold mb-1">${ review.message }</a>
              <div class="d-flex align-items-center mb-1 gap-2">
                <small class="mb-0">${ 2 }</small>
                <span>
                  <i class="bx bxs-star rate-star rating-star"></i>
                  <i class="bx bxs-star rate-star rating-star"></i>
                  <i class="bx bxs-star rate-star rating-star"></i>
                  <i class="bx bxs-star rate-star rating-star"></i>
                  <i class="bx bxs-star rate-star rating-star"></i>
                </span>
              </div>
              <p class="mb-0">${ 3 }</p>
            </div>
          </div>
        </div>
		<hr>
    `;
	$('#review-section').prepend(html);
}