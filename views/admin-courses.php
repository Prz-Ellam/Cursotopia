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
  
  <?= $this->link("styles/pages/admin-courses.css") ?>
  <?= $this->script("javascript/admin-courses.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>

  <section class="container-fluid">
    <div class="row flex-nowrap">
      <div class="col-auto collapse d-lg-block col-md-3 col-xl-2 px-sm-2 px-0 bg-primary">
        <div class="text-white">

          <ul class="nav nav-pills flex-column mb-auto nav-list sidebar">
            <li class="nav-item">
              <a href="/profile?id=<?= $this->session("id") ?>" class="nav-link text-white" aria-current="page">
                <i class='bx bxs-home'></i>
                Inicio
              </a>
            </li>
            <li>
              <a href="/admin/courses" class="nav-link text-white active">
                <i class='bx bxs-videos'></i>
                Cursos
              </a>
            </li>
            <li>
              <a href="/admin/categories" class="nav-link text-white">
                <i class='bx bxs-category'></i>
                Categorias
              </a>
            </li>
            <li>
              <a href="/blocked-users" class="nav-link text-white">
                <i class='bx bxs-group'></i>
                Usuarios
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="col py-3">

        <div class="content">
          <div class="container mt-3">

            <div class="row">
              <h2 class="fw-bold">Cursos</h2>
            </div>

            <div class="row">
              <div class="course-table col-12 me-3">
                <h4>Cursos pendientes de revisión</h4>
                <div class="row pt-3" id="no-more-tables">
                  <table class="table table-borderless">
                    <thead class="border-bottom text-center">
                      <tr>
                        <th>Curso</th>
                        <th>Usario</th>
                        <th>Detalle</th>
                        <th>Aceptar/Declinar</th>
                      </tr>
                    </thead>
                    <tbody id="notApprovedCourses">
                      <?php foreach($this->courses as $course): ?>
                      <tr class="text-center">
                        <td data-title="Curso"><?= $course["title"] ?></td>
                        <td data-title="Usuario"><?= $course["instructor"] ?></td>
                        <td data-title="Detalle">
                          <a class="btn btn-secondary rounded-pill" href="/course-details?id=<?= $course["id"] ?>">Ver detalles</a>
                        </td>
                        <td data-title="Aceptar/Declinar">
                          <button data-id="<?= $course["id"] ?>" class="btn border-0 btn-approve">
                            <i class="bx bxs-check-circle"></i>
                          </button>
                          <button data-id="<?= $course["id"] ?>" class="btn border-0 btn-denied">
                            <i class="bx bxs-x-circle"></i>
                          </button>
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
  </section>

  <!-- Footer -->
  <div class="container-fluid mt-auto bg-primary">
    <footer class="py-3 footer">
      <div class="col-md-4 d-flex align-items-center">
        <span class="mb-3 mb-md-0">&copy; 2023 Cursotopia. Todos los derechos reservados.</span>
      </div>
    </footer>
  </div>
</body>
</html>