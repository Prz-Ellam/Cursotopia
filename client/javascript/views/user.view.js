import $ from 'jquery';

export const showUnblockedUsers = (user) => {

      const html = `
      <tr class="text-center">
            <td data-title="Usuario">${ user.name } ${ user.lastName }</td>
            <td data-title="Detalle">
                <a class="btn btn-secondary rounded-pill" href="/instructor-profile-seen-by-others">Ver perfil</a>
            </td>
            <td data-title="Desbloquear">
                <button class="btn btn-danger rounded-pill block-btn" data-id="${ user.id }">Bloquear</button>
            </td>
        </tr>
      `;

      
      $('#unblockUsers').append(html);
}

export const showBlockedUsers = (user) => {

    const html = `
    <tr class="text-center">
        <td data-title="Usuario">
            ${ user.name } ${ user.lastName }
        </td>
        <td data-title="Detalle">
            <a class="btn btn-secondary rounded-pill" href="/student-profile-seen-by-others">Ver perfil</a>
        </td>
        <td data-title="Desbloquear">
            <button class="btn btn-secondary rounded-pill unblock-btn" data-id="${ user.id }">Desbloquear</button>
        </td>
    </tr>
    `;

    
    $('#blockUsers').append(html);
}