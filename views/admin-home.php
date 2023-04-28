<link rel="stylesheet" href="../client/styles/pages/admin-home.css">
<?= $this->script("javascript/admin-home.js") ?>

<main class="container-fluid">
  <div class="row flex-nowrap">
    <div class="col-auto collapse d-lg-block col-md-3 col-xl-2 px-sm-2 px-0 bg-primary">
      <div class="text-white">

        <ul class="nav nav-pills flex-column mb-auto nav-list sidebar">
          <li class="nav-item">
            <a href="profile?id=<?= $this->session("id") ?>" class="nav-link text-white active" aria-current="page">
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
            <a href="admin-categories" class="nav-link text-white">
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

      <div class="content">
        <div class="container mt-3">
          <!-- <div class="row">
            <h2>Información general</h2>
          </div> -->

          <!-- <div class="row d-flex mt-3">
            <div class="card d-flex w-50 me-3 col">
              <div class="card-body">
                <div class="row">
                  <div class="col-4  text-center">
                    <i class='bx bxs-videos'></i>
                  </div>
                  <div class="col-8">
                    <h5 class="card-title">Cursos</h5>
                    <h5 class="card-text">673</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="card d-flex w-50 me-3 col">
              <div class="card-body">
                <div class="row">
                  <div class="col-4  text-center">
                    <i class='bx bxs-graduation'></i>
                  </div>
                  <div class="col-8">
                    <h5 class="card-title">Estudiantes</h5>
                    <h5 class="card-text">5640</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="card d-flex w-50 me-3 col">
              <div class="card-body">
                <div class="row">
                  <div class="col-4  text-center">
                    <i class='bx bxs-face'></i>
                  </div>
                  <div class="col-8">
                    <h5 class="card-title">Instructores</h5>
                    <h5 class="card-text">1000</h5>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

          <!-- Gráficas -->
          <div>
            <h2 class="mt-3">Tú perfil</h2>
            <div class="col-12">
              <a href="profile-edition" class="btn btn-secondary shadow-none border-0 rounded-5">
                Editar perfil
              </a>
              <a href="password-edition" class="btn btn-secondary shadow-none border-0 rounded-5">
                Cambiar contraseña</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</main>