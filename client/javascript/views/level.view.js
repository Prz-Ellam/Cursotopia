import $ from 'jquery';

export default class LevelView {
  static createLevelSection = (level) => {
    const html = `
    <li class="level-item" data-id="${ level.id }">
      <div class="border-0 card shadow-none">
        <div class="rounded-top bg-light card-header">
          <div class="row align-items-center">
            <div class="col-9">
              <label>${ level.title }</label>
            </div>
            <div class="col-3 text-lg-end text-center">
              <button type="button" class="btn btn-sm btn-secondary rounded-pill create-lesson-btn"
                ct-target="${ level.id }">Añadir lección</button>
              <span class="d-lg-inline d-block text-lg-end text-center">
                <button ct-target="${ level.id }" type="button" class="btn text-success border-0 m-auto p-1 update-level-btn"
                  ><i class='bx bxs-pencil'></i></button>
                <button data-id="${ level.id }" type="button" class="btn text-danger border-0 m-auto p-1 delete-level-btn">
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

  static updateLevelSection = (level) => {
    const levelList = $(`#level-list-${level.id}`).html();
    $(`.level-item[data-id="${level.id}"]`).html(`
      <div class="border-0 card shadow-none">
        <div class="rounded-top bg-light card-header">
          <div class="row align-items-center">
            <div class="col-9">
              <label>${ level.title }</label>
            </div>
            <div class="col-3 text-lg-end text-center">
              <button type="button" class="btn btn-sm btn-secondary rounded-pill create-lesson-btn"
                ct-target="${ level.id }">Añadir lección</button>
              <span class="d-lg-inline d-block text-lg-end text-center">
                <button ct-target="${ level.id }" type="button" class="btn text-success border-0 m-auto p-1 update-level-btn"
                  ><i class='bx bxs-pencil'></i></button>
                <button data-id="${ level.id }" type="button" class="btn text-danger border-0 m-auto p-1 delete-level-btn">
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
          ${ levelList }
        </ul>
      </div>
  `)
  }

  static deleteLevelSection = (id) => {
    $(`.level-item[data-id="${id}"]`).remove();
  }
}

export const courseCreationCreateLevelSection = (level) => {
  const html = `
    <li class="level-item" data-id="${ level.id }">
      <div class="border-0 card shadow-none">
        <div class="rounded-top bg-light card-header">
          <div class="row align-items-center">
            <div class="col-9">
              <label for="">${ level.title }</label>
            </div>
            <div class="col-3 text-lg-end text-center">
              <button type="button" class="btn btn-sm btn-secondary rounded-pill create-lesson-btn"
                ct-target="${ level.id }">Añadir lección</button>
              <span class="d-lg-inline d-block text-lg-end text-center">
                <button ct-target="${ level.id }" type="button" class="btn text-success border-0 m-auto p-1 update-level-btn"
                  ><i class='bx bxs-pencil'></i></button>
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