import $ from 'jquery';

export const showNotApprovedCourses = (course) => {
    console.log("view");
    const html = `
    <tr class="text-center">
        <td data-title="Curso">${course.title}</td>
        <td data-title="Usuario">${course.instructor}</td>
        <td data-title="Detalle">
            <a class="btn btn-secondary rounded-pill" href="/course-details?id= ${course.id}">Ver detalles</a>
        </td>
        <td data-title="Aceptar/Declinar">
            <button data-id="${course.id}" class="btn border-0 btn-approve">
                <i class="bx bxs-check-circle"></i>
            </button>
            <button data-id="${course.id}" class="btn border-0 btn-denied">
                <i class="bx bxs-x-circle"></i>
            </button>
        </td>
    </tr>
    `;
    $('#notApprovedCourses').append(html);
}