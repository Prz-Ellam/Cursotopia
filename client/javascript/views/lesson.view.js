import $ from 'jquery';

export default class LessonView {
  static createLessonSection = (lesson) => {
    const html = `
      <li data-id="${ lesson.id }" class="lesson-item list-group-item d-flex align-items-center justify-content-between${(lesson.video) !== '' ? ' video' : ''}">
        <span>${ lesson.title }</span>
        <span>
          <button data-id="${ lesson.id }" type="button" class="update-lesson-btn btn text-success border-0 m-auto p-1">
            <i class="bx bxs-pencil"></i>
          </button>
          <button data-id="${ lesson.id }" type="button" class="delete-lesson-btn btn text-danger border-0 m-auto p-1">
            <i class="bx bxs-trash-alt"></i>
          </button>
        </span>
      </li>
    `;
    $(`#level-list-${lesson.level}`).append(html);
  }

  static updateLessonSection = (lesson) => {
    $(`.lesson-item[data-id="${lesson.id}"]`).html(`
      <span>${lesson.title}</span>
      <span>
        <button data-id="${ lesson.id }" type="button" class="update-lesson-btn btn text-success border-0 m-auto p-1">
          <i class="bx bxs-pencil"></i>
        </button>
        <button data-id="${ lesson.id }" type="button" class="delete-lesson-btn btn text-danger border-0 m-auto p-1">
          <i class="bx bxs-trash-alt"></i>
        </button>
      </span>
    `);
  }

  static deleteLessonSection = (id) => {
    $(`.lesson-item[data-id="${id}"]`).remove();
  }
}

export const courseCreationCreateLessonSection = (lesson) => {
  const html = `
    <li data-id="${ lesson.id }" class="list-group-item d-flex align-items-center justify-content-between${(lesson.video) !== '' ? ' video' : ''}">
      <span>${lesson.title}</span>
      <span>
        <button type="button" class="update-lesson-btn btn text-success border-0 m-auto p-1">
          <i class="bx bxs-pencil"></i>
        </button>
        <button type="button" class="delete-lesson-btn btn text-danger border-0 m-auto p-1">
          <i class="bx bxs-trash-alt"></i>
        </button>
      </span>
    </li>
    `;
  $(`#level-list-${lesson.level}`).append(html);
}