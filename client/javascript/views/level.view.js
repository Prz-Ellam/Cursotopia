import $ from 'jquery';

export const courseCreationCreateLevelSection = (level) => {
  const html = `
    <li class="level-item">
      <div class="border-0 card shadow-none">
        <div class="rounded-top bg-light card-header">
          <div class="row align-items-center">
            <div class="col-9">
              <label for="">${ level.title }</label>
            </div>
            <div class="col-3 text-lg-end text-center">
              <button type="button" class="btn btn-sm btn-secondary rounded-pill add-lesson-btn"
                ct-target="${ level.id }">Añadir lección</button>
              <span class="d-lg-inline d-block text-lg-end text-center">
                <a id="edit-level-btn" href="#" class="btn text-success border-0 m-auto p-1" data-bs-toggle="modal"
                  data-bs-target="#editLevel"><i class='bx bxs-pencil'></i></a>
                <button type="button" class="btn text-danger border-0 m-auto p-1 delete-level-btn">
                  <i class='bx bxs-trash-alt'></i>
                </button>
                <a class="btn text-primary border-0 m-auto p-1" href="#collapse-${level.id}" data-bs-toggle="collapse"
                  role="button" aria-expanded="false" aria-controls="collapse-${level.id}">
                  <i class='bx bxs-chevron-down'></i>
                </a>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="collapse" id="collapse-${level.id}">
        <ul class="list-group list-group-flush lessons-container" id="level-list-${level.id}">
        </ul>
      </div>
    </li>
    `;
		$('#levels-container').append(html);
}