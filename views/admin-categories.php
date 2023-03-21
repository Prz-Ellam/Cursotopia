<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->env("APP_NAME") ?></title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">

  <!-- SweetAlert -->
  <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">

  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../client/styles/pages/admin-categories.css">
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <?= $this->script("javascript/admin-categories.js") ?>
</head>

<body>
  <!-- Navbar -->
  <nav class="sticky-top navbar navbar-expand-lg bg-primary shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand text-light" href="home">Cursotopia</a>
      <button class="border-0 shadow-none navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="text-white bx-sm bx bx-menu"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-content">
        <form class="col-auto col-lg-6" role="search" action="search">
          <div class="input-group">
            <input class="form-control bg-white" type="search" placeholder="Buscar cursos..." aria-label="Search">
            <button class="btn btn-white border-0 text-dark search-btn" type="submit">
              <i class="fw-bold bx bx-search"></i>
            </button>
          </div>
        </form>
        <ul class="navbar-nav ms-auto d-lg-flex align-items-lg-center me-2">
          <li class="nav-item dropdown">
            <a class="nav-link fw-bold text-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Categorías
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="search">Arte</a></li>
              <li><a class="dropdown-item" href="search">Música</a></li>
              <li><a class="dropdown-item" href="search">Programación</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" aria-current="page" href="chat">
              <i class="bx-sm bx bxs-bell position-relative">
                <span class="badge rounded-pill badge-notification bg-danger">1</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <div class="nav-link dropdown">
              <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../client/assets/images/perfil.png" alt="mdo" width="32"
                  class="rounded-circle profile-picture">
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item" href="instructor-profile">Mi perfil</a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item" href="#">Cerrar sesión</a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container-fluid">
    <div class="row flex-nowrap">
      <div class="col-auto collapse d-lg-block col-md-3 col-xl-2 px-sm-2 px-0 bg-primary">
        <div class="text-white">
          <ul class="nav nav-pills flex-column mb-auto nav-list sidebar">
            <li class="nav-item">
              <a href="admin-home" class="nav-link text-white" aria-current="page">
                <i class='bx bxs-home'></i>
                Home
              </a>
            </li>
            <li>
              <a href="admin-courses" class="nav-link text-white">
                <i class='bx bxs-videos'></i>
                Cursos
              </a>
            </li>
            <li>
              <a href="admin-categories" class="nav-link text-white active">
                <i class='bx bxs-category'></i>
                Categorias
              </a>
            </li>
            <li>
              <a href="blocked-users" class="nav-link text-white">
                <i class='bx bxs-group'></i>
                Usuarios
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="col py-3">
        <div class="mt-3">
          <h2>Categorias</h2>

          <div class="row">

            <div class="col-md-8 col-sm-12 categories-table me-3 mt-4">
              <h4>Categorias pendientes de revisión</h4>
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
                  <tbody>
                    <tr class="text-center">
                      <td data-title="Curso">BDM</td>
                      <td data-title="Usuario">Denisse Cardoza</td>
                      <td data-title="Detalle">
                        <button class="btn btn-secondary rounded-pill update-category-btn">
                          Ver detalles
                        </button>
                      </td>
                      <td data-title="Aceptar/Declinar">
                        <button class="btn border-0 approve-btn"><i class='bx bxs-check-circle'></i></button>
                        <button class="btn border-0 denied-btn"><i class='bx bxs-x-circle'></i></button></td>
                    </tr>
                    <tr class="text-center">
                      <td data-title="Curso">BDM</td>
                      <td data-title="Usuario">Denisse Cardoza</td>
                      <td data-title="Detalle">
                        <button class="btn btn-secondary rounded-pill update-category-btn">
                          Ver detalles
                        </button>
                      </td>
                      <td data-title="Aceptar/Declinar">
                        <button class="btn border-0 approve-btn"><i class='bx bxs-check-circle'></i></button>
                        <button class="btn border-0 denied-btn"><i class='bx bxs-x-circle'></i></button></td>
                      </td>
                    </tr>
                    <tr class="text-center">
                      <td data-title="Curso">BDM</td>
                      <td data-title="Usuario">Denisse Cardoza</td>
                      <td data-title="Detalle">
                        <button class="btn btn-secondary rounded-pill update-category-btn">
                          Ver detalles
                        </button>
                      </td>
                      <td data-title="Aceptar/Declinar">
                        <button class="btn border-0 approve-btn"><i class='bx bxs-check-circle'></i></button>
                        <button class="btn border-0 denied-btn"><i class='bx bxs-x-circle'></i></button></td>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 categories mt-4">
              <h4 class="text-center mb-4">Categorias</h4>
              <div class="d-flex">
                <p class="">Programación</p>
                <button class="btn ms-auto update-category-btn text-success border-0">
                  <i class='bx bxs-pencil'></i>
                </button>
                <button class="btn p-0"><i class='bx bxs-x-circle'></i></button>
              </div>
              <div class="d-flex">
                <p class="">Cocina</p>
                <button class="btn ms-auto update-category-btn text-success border-0">
                  <i class='bx bxs-pencil'></i>
                </button>
                <button class="btn p-0"><i class='bx bxs-x-circle'></i></button>
              </div>
            </div>

            <div class="col-12 disabled-categories-table me-3 mt-4 mb-4">
              <h4>Categorias desactivadas</h4>
              <div class="row pt-3" id="no-more-tables">
                <table class="table table-borderless">
                  <thead class="border-bottom text-center">
                    <tr>
                      <th>Categoría</th>
                      <th>Usario</th>
                      <th>Detalle</th>
                      <th>Activar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="text-center">
                      <td data-title="Categoría">BDM</td>
                      <td data-title="Usuario">Denisse Cardoza</td>
                      <td data-title="Detalle">
                        <button class="btn btn-secondary rounded-pill update-category-btn">
                          Ver detalles
                        </button>
                      </td>
                      <td data-title="Activar">
                        <button class="btn btn-secondary rounded-pill">Activar</button>
                      </td>
                    </tr>
                    <tr class="text-center">
                      <td data-title="Categoría">BDM</td>
                      <td data-title="Usuario">Denisse Cardoza</td>
                      <td data-title="Detalle">
                        <button class="btn btn-secondary rounded-pill update-category-btn">
                          Ver detalles
                        </button>
                      </td>
                      <td data-title="Activar">
                        <button class="btn btn-secondary rounded-pill">Activar</button>
                      </td>
                    </tr>
                    <tr class="text-center">
                      <td data-title="Categoría">BDM</td>
                      <td data-title="Usuario">Denisse Cardoza</td>
                      <td data-title="Detalle">
                        <button class="btn btn-secondary rounded-pill update-category-btn">
                          Ver detalles
                        </button>
                      </td>
                      <td data-title="Activar">
                        <button class="btn btn-secondary rounded-pill">Activar</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Modal editar categoria-->
  <div class="modal fade" id="update-category-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="#" class="modal-content rounded-1 border-0 shadow-sm" id="update-category-form">
        <div class="modal-header">
          <h4>Categoría</h4>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-4">
            <label for="category-name" class="form-label" role="button">Nombre</label>
            <input type="text" class="form-control" id="category-name" name="name" autocomplete="off">
          </div>
          <div class="mb-4">
            <label for="category-description" class="form-label" role="button">Descripción</label>
            <textarea class="form-control" id="category-description" name="description" rows="5"
              placeholder="¿Qué clase de cursos contendrá?"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button id="close-btn" type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Close</button>
          <button id="save-btn" type="submit" class="btn btn-primary rounded-pill">Save changes</button>
        </div>
      </form>
    </div>
  </div>

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