<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->env("APP_NAME") ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../client/styles/pages/admin-home.css">
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js" integrity="sha512-v3ygConQmvH0QehvQa6gSvTE2VdBZ6wkLOlmK7Mcy2mZ0ZF9saNbbk19QeaoTHdWIEiTlWmrwAL4hS8ElnGFbA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <?= $this->script("javascript/admin-home.js") ?>
</head>
<body>
  <main class="container-fluid">
    <div class="row flex-nowrap">
      <div class="col-auto collapse d-lg-block col-md-3 col-xl-2 px-sm-2 px-0 bg-primary">
        <div class="text-white">

          <ul class="nav nav-pills flex-column mb-auto nav-list sidebar">
            <li class="nav-item">
              <a href="admin-home" class="nav-link text-white active">
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
              <a href="admin-categories" class="nav-link text-white">
                <i class='bx bxs-category'></i>
                Categorias
              </a>
            </li>
            <li>
              <a href="blocked-users" class="nav-link text-white">
                <i class='bx bxs-group' ></i>
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
              <h2>Información general</h2>
            </div>
      
            <div class="row d-flex mt-3">
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
            </div>   

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
</body>
</html>