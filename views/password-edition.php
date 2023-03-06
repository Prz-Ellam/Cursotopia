<?php ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cursotopia</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <script src="https://kit.fontawesome.com/812dd4b211.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
  
  <link rel="stylesheet" href="../dist/assets/password-edition.css">
  <script defer type="module" src="../dist/javascript/password-edition.js"></script>
</head>
<body>
  <!-- Navbar -->
  <nav class="sticky-top navbar navbar-expand-lg bg-primary shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand text-white" href="home">
        <img src="../client/assets/images/logo.png" alt="Logo" width="34" height="34"
          class="d-inline-block align-text-top">
        <span class="align-middle">Cursotopia</span>
      </a>
      <button class="border-0 shadow-none navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="text-white bx-sm bx bx-menu"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-content">
        <form class="col-md-auto col-lg-5 col-xl-7" role="search" action="search">
          <div class="input-group">
            <input class="form-control bg-white" type="search" placeholder="Buscar cursos..." aria-label="Search">
            <button class="btn btn-white border-0 text-dark search-btn" type="submit">
              <i class="fw-bold bx bx-search"></i>
            </button>
          </div>
        </form>
        <ul class="navbar-nav ms-auto d-lg-flex align-items-lg-center me-2">
          <li class="nav-item">
            <a href="course-creation" class="nav-link fw-bold text-light">
              Crear curso
            </a>
          </li>
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
  <main class="container my-5">

<!-- 
    <div class="px-3 mt-3 mb-0 alert alert-secondary border-0 p-2" role="alert">
      <a href="instructor-profile" class="text-decoration-none text-primary">
        Mi cuenta
      </a> / Editar contraseña
    </div> -->

    <div class="row d-flex justify-content-center">

      <form action="" class="col-lg-6 col-md-6" id="password-edition-form">
            
        <div class="border-3 border-bottom border-primary text-center mb-4">
          <h1>Editar contraseña</h1>
        </div>

        <div class="mb-4">
          <label for="old-password" role="button" class="form-label">Contraseña anterior</label>
          <div class="input-group">
            <input type="password" name="old-password" id="old-password" class="form-control">
            <button type="button" class="btn btn-primary btn-password" id="old-password-button"
              ct-target="old-password">
              <i class="fa-solid fa-eye-slash fa-eye"></i>
            </button>
          </div>
        </div>
    
        <div class="mb-4">
          <label for="new-password" role="button" class="form-label">Confirmar contraseña</label>
          <div class="input-group">
            <input type="password" name="new-password" id="new-password" class="form-control">
            <button type="button" class="btn btn-primary btn-password" id="new-password-button"
              ct-target="new-password">
              <i class="fa-solid fa-eye-slash fa-eye"></i>
            </button>
          </div>
          <ul class="mt-1">
            <!-- <li class="lower">Una minuscula</li> -->
            <li id="password-length">Mínimo 8 caracteres</li>
            <li id="password-mayus">Una mayuscula</li>
            <li id="password-number">Un número</li>
            <li id="password-specialchar">Una caracter especial</li>
          </ul>
        </div>
    
        <div class="mb-4">
          <label for="confirm-new-password" role="button" class="form-label">Confirmar contraseña</label>
          <div class="input-group">
            <input type="password" name="confirm-new-password" id="confirm-new-password" class="form-control">
            <button type="button" class="btn btn-primary btn-password" id="confirm-new-password-button"
              ct-target="confirm-new-password">
              <i class="fa-solid fa-eye-slash fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="d-grid mb-4">
          <button type="submit" class="btn btn-primary rounded-pill">Actualizar contraseña</button>
        </div>

        <!--
        <a href="" class="d-block text-primary text-center text-decoration-none">¿Olvidaste tú contraseña?</a>
        -->
      </form>
    </div>
  </main>
  <!-- Footer -->
  <footer class="page-footer p-5 bg-light">
    <div class="container-fluid">
      <div class="row text-md-start text-center">
        <div class="col-md-3 mx-auto mb-3">
          <ul class="list-unstyled">
            <li class="my-2">
              <a href=""><img src="../client/assets/images/logo.png" width="200" class="img-fluid" id="logo-banner" alt="Logo Banner"></a>
            </li>
          </ul>
        </div>
        <div class="col-md-3 mx-auto mb-3">
          <h5 class="text-uppercase mb-4 text-cream fw-bold">Recursos</h5>
          <ul class="list-unstyled">
            <li class="my-2"><a href="#" class="text-primary text-decoration-none">Acerca de nosotros</a><br></li>
            <li class="my-2"><a href="#" class="text-primary text-decoration-none">Contáctanos</a><br></li>
            <li class="my-2"><a href="#" class="text-primary text-decoration-none">Preguntas frecuentes</a><br></li>
          </ul>
        </div>
        <div class="col-md-3 mx-auto mb-3">
          <h5 class="text-uppercase mb-4 text-cream fw-bold">Políticas</h5>
          <ul class="list-unstyled">
            <li class="my-2"><a href="#" class="text-primary text-decoration-none">Política de privacidad</a><br></li>
          </ul>
        </div>
        <div class="col-md-3 mx-auto mb-3">
          <h5 class="text-uppercase mb-4 text-cream fw-bold">Contacto</h5>
          <ul class="list-unstyled">
            <li class="my-2">
              <a href="https://www.facebook.com" target="_blank" class="d-flex justify-content-md-start justify-content-center align-items-center text-primary text-decoration-none">
                <i class='text-primary bx-sm bx bxl-facebook-square me-2'></i>Facebook
              </a>
            </li>
            <li class="my-2">
              <a href="https://www.instagram.com" target="_blank" class="d-flex justify-content-md-start justify-content-center text-primary text-decoration-none">
                <i class='text-primary bx-sm bx bxl-instagram-alt me-2' ></i>Instagram
              </a>
            </li>
            <li class="my-2">
              <a href="tel:(00)00000000" class="d-flex justify-content-md-start justify-content-center text-primary text-decoration-none">
                <i class='text-primary bx-sm bx bxs-phone me-2'></i>(00)-0000-0000
              </a>
            </li>
            <li class="my-2">
              <a href="mailto:cursotopia@gmail.com.mx" class="d-flex justify-content-md-start justify-content-center text-primary text-decoration-none">
                <i class='text-primary bx-sm bx bxs-envelope me-2' ></i>Correo electrónico
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="container">
        <div class="row pt-5 pb-3 d-flex align-items-center">
          <div class="col-md-12  text-center">

          </div>
        </div>
      </div>
      <div class="container text-center img-responsive">
        <p class="text-cream mb-0">&copy; 2023 Curstopia. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>
</body>
</html>