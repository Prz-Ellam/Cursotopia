import $ from 'jquery';

export const createReview = (review) => {

  const date = new Date();
  const options = {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: 'numeric',
    minute: 'numeric'
  };
  const formattedDate = date.toLocaleString('es-MX', options);

    const html = `
    <div class="card-body p-4">
      <div class="d-flex flex-start">
        <img 
          class="rounded-circle shadow-1-strong me-3"
          src="/api/v1/images/${ review.image }" 
          alt="avatar" width="60" height="60">
        <div>
          <div class="d-flex justify-content-between">
            <div>
            <a class="fw-bold mb-1">${ review.username }</a>
            <div class="d-flex align-items-center mb-1 gap-2">
              <small class="mb-0">${ formattedDate }</small>
              <span>
                <i class="bx ${ review.rate >= 1 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                <i class="bx ${ review.rate >= 2 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                <i class="bx ${ review.rate >= 3 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                <i class="bx ${ review.rate >= 4 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                <i class="bx ${ review.rate >= 5 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
              </span>
            </div>
          </div>
          <a href="#"
            class="nav-link"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item delete-review" reviewId=${review.id}>Eliminar</a></li>
          </ul>
          </div>
          <p class="mb-0">${ review.message }</p>
        </div>
      </div>
    </div>
		<hr>
    `;
	$('#review-section').prepend(html);
}

export const showMoreReviews = (review, userId, userRol) => {

  const date = new Date(review.createdAt);
  const options = {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: 'numeric',
    minute: 'numeric'
  };
  const formattedDate = date.toLocaleString('es-MX', options);

  const html = `
  <div class="card-body p-4">
    <div class="d-flex flex-start">
      <img 
        class="rounded-circle shadow-1-strong me-3"
        src="/api/v1/images/${ review.profilePicture }" 
        alt="avatar" width="60" height="60"/>
        <div>
          <div class="d-flex justify-content-between">
            <div>
              <a class="fw-bold mb-1">${ review.userName }</a>
              <div class="d-flex align-items-center mb-1 gap-2">
                <small class="mb-0">${ formattedDate }</small>
                <span>
                  <i class="bx ${ review.rate >= 1 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 2 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 3 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 4 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 5 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                </span>
              </div>
            </div>
            <a href="#"
              class="nav-link"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item delete-review" reviewId=${review.id}>Eliminar</a></li>
            </ul>
          </div>
          <p class="mb-0">${ review.message }</p>
      </div>
    </div>
  </div>
  <hr>
  `;

  const html2 = `
  <div class="card-body p-4">
    <div class="d-flex flex-start">
      <img 
        class="rounded-circle shadow-1-strong me-3"
        src="/api/v1/images/${ review.profilePicture }" 
        alt="avatar" width="60" height="60"/>
        <div>
          <div class="d-flex justify-content-between">
            <div>
              <a class="fw-bold mb-1">${ review.userName }</a>
              <div class="d-flex align-items-center mb-1 gap-2">
                <small class="mb-0">${ formattedDate }</small>
                <span>
                  <i class="bx ${ review.rate >= 1 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 2 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 3 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 4 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                  <i class="bx ${ review.rate >= 5 ? 'bxs-star' : 'bx-star' } rate-star rating-star"></i>
                </span>
              </div>
            </div>
          </div>
          <p class="mb-0">${ review.message }</p>
      </div>
    </div>
  </div>
  <hr>
  `; 

if(userRol===1 || userId===review.userId){
  $('#review-section').append(html);
}else{
  $('#review-section').append(html2);
}

}