import $ from 'jquery';

export const courseCreationCreateLessonSection = (lesson) => {
    const html = `
    <li class="list-group-item d-flex align-items-center justify-content-between${ (lesson.video) !== '' ? ' video' : '' }">
        <span>${ lesson.title }</span>
        <span>
            <a href="#" class="edit-lesson-btn btn text-success border-0 m-auto p-1" data-bs-toggle="modal"
                data-bs-target="#edit-lesson"><i class='bx bxs-pencil'></i></a>
            <button type="button" class="delete-lesson-btn btn text-danger border-0 m-auto p-1">
                <i class='bx bxs-trash-alt'></i>
            </button>
        </span>
    </li>
    `;
    $(`#level-list-${ lesson.level }`).append(html);
}