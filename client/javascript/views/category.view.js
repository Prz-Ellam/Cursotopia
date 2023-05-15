import $ from 'jquery';

export const showApprovedCategories = (category) => {

      const html = `
      <div class="d-flex">
        <p class="">${ category.name }</p>
        <button class="btn ms-auto update-category-btn text-success border-0 edit-btn" data-id="${ category.id }">
            <i class='bx bxs-pencil'></i>
        </button>
        <!--button class="btn p-0 deactivate-btn" data-id="${ category.id }">
            <i class='bx bxs-x-circle'></i>
        </button-->
      </div>
      `;
      $('#approvedCategories').append(html);
}

export const showNotApprovedCategories = (category) => {

    const html = `
    <tr class="text-center">
        <td data-title="Curso">${ category.name }</td>
        <td data-title="Usuario">${ category.user }</td>
        <td data-title="Aceptar/Declinar">
            <button class="btn border-0 approve-btn" data-id="${ category.id }"><i class='bx bxs-check-circle' ></i></button>
            <button class="btn border-0 denied-btn" data-id="${ category.id }"><i class='bx bxs-x-circle' ></i></button></td>
    </tr>
    `;
    $('#notApprovedCategories').append(html);
}

export const showNotActiveCategories = (category) => {

    const html = `
    <tr class="text-center">
        <td data-title="Categoría">${ category.name }</td>
        <td data-title="Usuario">${ category.user }</td>
        <td data-title="Detalle">
            <button class="btn btn-secondary rounded-pill update-category-btn details-btn" data-id="${ category.id }">
                Ver detalles
            </button>
        </td>
        <td data-title="Activar">
            <button class="btn btn-secondary rounded-pill activate-btn" data-id="${ category.id }">Activar</button>
        </td>
    </tr>
    `;
    $('#inactiveCategories').append(html);
}