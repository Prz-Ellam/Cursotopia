<!DOCTYPE html>
<html lang="<?= LANG ?>">
<head>
  <meta charset="<?= CHARSET ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->env("APP_NAME") ?></title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">

  <!-- Boxicons -->
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">

  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <?= $this->link("styles/pages/blocked-users.css") ?>
  <?= $this->script("javascript/blocked-users.js") ?>

  <!-- SweetAlert -->
  <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
</head>

<body>
  <?= $this->render("partials/navbar") ?>

  <div class="container-fluid">
    <div class="row flex-nowrap">
      <div class="col-auto collapse d-lg-block col-md-3 col-xl-2 px-sm-2 px-0 bg-primary">
        <div class="text-white">

          <ul class="nav nav-pills flex-column mb-auto nav-list sidebar">
            <li class="nav-item">
              <a href="profile?id=<?= $this->session("id") ?>" class="nav-link text-white" aria-current="page">
                <i class='bx bxs-home'></i>
                Inicio
              </a>
            </li>
            <li>
              <a href="admin-courses" class="nav-link text-white">
                <i class='bx bxs-videos'></i>
                Cursos
              </a>
            </li>
            <li>
              <a href="admin/categories" class="nav-link text-white">
                <i class='bx bxs-category'></i>
                Categorias
              </a>
            </li>
            <li>
              <a href="blocked-users" class="nav-link text-white active">
                <i class='bx bxs-group' ></i>
                Usuarios
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col py-3">
        
        <div class="container">
          <h2 class="fw-bold">Usuarios</h2>
          
    
          <div class="row">
            <div class="blocked-users-table col-12 me-3 mt-2">
              <h4>Usuarios bloqueados</h4>
              <div class="row pt-3" id="no-more-tables">
                <table class="table table-borderless">
                  <thead class="border-bottom text-center">
                    <tr>
                      <th>Usuario</th>
                      <th>Detalle</th>
                      <th>Desbloquear</th>
                    </tr>
                  </thead>
                    <tbody id="blockUsers">
                      <?php foreach($this->blockedUsers as $user): ?>
                      <tr class="text-center">
                        <td data-title="Usuario">
                          <?= $user["name"] ?> <?= $user["lastName"] ?>
                        </td>
                        <td data-title="Detalle">
                          <a class="btn btn-secondary rounded-pill" href="student-profile-seen-by-others">Ver perfil</a>
                        </td>
                        <td data-title="Desbloquear">
                          <button class="btn btn-secondary rounded-pill unblock-btn" id="<?= $user["id"] ?>">Desbloquear</button>
                        </td>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="blocked-users-table col-12 me-3 mt-4">
                <h4>Usuarios de la plataforma</h4>
                <div class="row pt-3" id="no-more-tables">
                  <table class="table table-borderless">
                    <thead class="border-bottom text-center">
                      <tr>
                        <th>Usuario</th>
                        <th>Detalle</th>
                        <th>Bloquear</th>
                      </tr>
                    </thead>
                    <tbody id="unblockUsers">
                      <?php foreach($this->users as $user): ?>
                        <tr class="text-center">
                          <td data-title="Usuario"><?= $user["name"] ?> <?= $user["lastName"] ?></td>
                          <td data-title="Detalle">
                            <a class="btn btn-secondary rounded-pill" href="instructor-profile-seen-by-others">Ver perfil</a>
                          </td>
                          <td data-title="Desbloquear">
                            <button class="btn btn-secondary rounded-pill block-btn" id="<?= $user["id"] ?>">Bloquear</button>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
    
          </div>
        
      </div>
    </div>
  </div>

</body>

</html>