<?php use Cursotopia\Helpers\Auth; ?>
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
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="../client/styles/pages/home.css">
  <script defer type="module" src="../dist/javascript/home.js"></script>
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
</head>
<body>
  <?php if (Auth::auth(1)): ?>
  <!-- Navbar de instructor --> 
  <nav class="sticky-top navbar navbar-expand-lg bg-primary shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand text-white" href="home">
        <img src="../client/assets/images/logo.png" alt="Logo" width="34" height="34" class="d-inline-block align-text-top">
        <span class="align-middle">Cursotopia</span>
      </a>
      <button 
        class="border-0 shadow-none navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbar-content"
        aria-controls="navbar-content"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="text-white bx-sm bx bx-menu"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-content">
        <form class="col-md-auto col-lg-5 col-xl-7" role="search" action="search">
          <div class="input-group">
            <input
              class="form-control bg-white"
              type="search"
              placeholder="Buscar cursos..."
              aria-label="Search">
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
            <a
              class="nav-link fw-bold text-light dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
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
              <button
                class="btn border-0 p-0"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <img 
                  src="../client/assets/images/perfil.png"
                  alt="mdo"
                  width="32"
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
  <?php elseif (Auth::auth(2)): ?>
  <!-- Navbar de estudiante --> 
  <nav class="sticky-top navbar navbar-expand-lg bg-primary shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand text-white" href="home">
        <img src="../client/assets/images/logo.png" alt="Logo" width="34" height="34" class="d-inline-block align-text-top">
        <span class="align-middle">Cursotopia</span>
      </a>
      <button 
        class="border-0 shadow-none navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbar-content"
        aria-controls="navbar-content"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="text-white bx-sm bx bx-menu"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-content">
        <form class="col-md-auto col-lg-5 col-xl-7" role="search" action="search">
          <div class="input-group">
            <input
              class="form-control bg-white"
              type="search"
              placeholder="Buscar cursos..."
              aria-label="Search">
            <button class="btn btn-white border-0 text-dark search-btn" type="submit">
              <i class="fw-bold bx bx-search"></i>
            </button>
          </div>
        </form>
        <ul class="navbar-nav ms-auto d-lg-flex align-items-lg-center me-2">
          <li class="nav-item">
            <a href="course-creation" class="nav-link fw-bold text-light">
              Mis cursos
            </a>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link fw-bold text-light dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
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
              <button
                class="btn border-0 p-0"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <img 
                  src="../client/assets/images/perfil.png"
                  alt="mdo"
                  width="32"
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
  <?php else: ?>
  <!-- Navbar sin sesión -->
  <nav class="sticky-top navbar navbar-expand-lg bg-primary shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand text-white" href="home">
        <img src="../client/assets/images/logo.png" alt="Logo" width="34" height="34" class="d-inline-block align-text-top">
        <span class="align-middle">Cursotopia</span>
      </a>
      <button 
        class="border-0 shadow-none navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbar-content"
        aria-controls="navbar-content"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="text-white bx-sm bx bx-menu"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-content">
        <form class="col-md-auto col-lg-5 col-xl-7" role="search" action="search">
          <div class="input-group">
            <input
              class="form-control bg-white"
              type="search"
              placeholder="Buscar cursos..."
              aria-label="Search">
            <button class="btn btn-white border-0 text-dark search-btn" type="submit">
              <i class="fw-bold bx bx-search"></i>
            </button>
          </div>
        </form>
        <ul class="navbar-nav ms-auto d-lg-flex align-items-lg-center me-2">
          <li class="nav-item dropdown">
            <a
              class="nav-link fw-bold text-light dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Categorías
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="search">Arte</a></li>
              <li><a class="dropdown-item" href="search">Música</a></li>
              <li><a class="dropdown-item" href="search">Programación</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="signup" class="nav-link fw-bold text-light d-flex align-items-center">
              <i class='bx-sm bx bxs-user-plus'></i>Registrarse
            </a>
          </li>
          <li class="nav-item">
            <a href="login" class="nav-link fw-bold text-light d-flex align-items-center">
              <i class='bx-sm bx bxs-user-check' ></i>Iniciar sesión
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <?php endif ?>
  
  <!-- Hero Section -->
  <section class="position-relative d-flex flex-column justify-content-center mb-5" id="hero-section">
    <div class="container">
      <div class="row g-0">
        <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up">
          <div class="text-center text-lg-start">
            <img src="../client/assets/images/logo.png" alt="Logo" width="128">
          </div>
          <h1 class="fw-bolder text-center text-lg-start">Cursotopia</h1>
          <h5 class="text-center text-lg-start">Aprende todo lo que tu quieras, ¡al alcance de un click!</h5>
          <h5 class="mb-4 text-center text-lg-start">Forjamos la sociedad del mañana con nuestros cursos</h5>
          <!-- Sin sesion -->
          <div class="d-flex justify-content-lg-start justify-content-center">
            <a href="signup" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Crea una cuenta gratis!</a>
          </div>
          <!-- Con sesion estudiante --> 
          <!-- <div class="d-flex justify-content-lg-start justify-content-center">
            <a href="search" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Explorar cursos!</a>
          </div> -->
          <!-- Con sesion de instructor -->
          <!-- <div class="d-flex justify-content-lg-start justify-content-center">
            <a href="course-creation" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Crea un curso!</a>
          </div> -->
        </div>
        <div class="col-lg-6" data-aos="zoom-in-up">
          <img
            src="../client/assets/images/hero-banner.svg"
            class="img-fluid w-100 d-none d-lg-block"
            alt="Hero Banner"
          >
        </div>
      </div>
    </div>
  </section>

  <section class="container-fluid mb-5" data-aos="fade-up" id="section-recent-courses">
    <h2 class="text-center fw-bolder">Últimos cursos publicados</h2>
    <hr>
    <div class="px-5 owl-carousel owl-theme">

      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/1948561/HVgczjlDQjK5CIXpb57p_desarrollo-web-con-html-css-min.png"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Crea páginas web con HTML y CSS</h5>
          <p class="card-text">Paco Gomez Arnal</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$250.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class='bx bxs-star-half rate-star rating-star'></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/1652554/m8sF2qn5R7WkrFrvDAJe_Seguridad%20pc-min.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Cómo protegerse en la red</h5>
          <p class="card-text">Kike Gandia</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$230.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/557614/hr1BWk5LTF2jiAziFPH0_aprende-a-programar-de-cero-con-python-min.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Aprende a programar en Python</h5>
          <p class="card-text">Nate Gentile</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$350.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>
      
      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/1995678/Qe69BGYXRGqYxVIO1kae_codigo-limpio-del-siglo-xx1.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Código limpio del siglo XXI (Clean code)</h5>
          <p class="card-text">Martin aka BettaTech</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$300.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/2024609/F2TifraHR26mbZmPxsS0_historia-de-la-tarjeta-grafica-min.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Historia de la tarjeta gráfica</h5>
          <p class="card-text">Arturo Alonso Alonso</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$200.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

    </div>
  </section>

  <section class="container-fluid mb-5" data-aos="fade-up">
    <h2 class="text-center fw-bolder">Los cursos mejor valorados</h2>
    <hr>
    <div class="px-5 owl-carousel owl-theme">
      
      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/1948561/HVgczjlDQjK5CIXpb57p_desarrollo-web-con-html-css-min.png"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Crea páginas web con HTML y CSS</h5>
          <p class="card-text">Paco Gomez Arnal</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$250.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class='bx bxs-star-half rate-star rating-star'></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/1652554/m8sF2qn5R7WkrFrvDAJe_Seguridad%20pc-min.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Cómo protegerse en la red</h5>
          <p class="card-text">Kike Gandia</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$230.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/557614/hr1BWk5LTF2jiAziFPH0_aprende-a-programar-de-cero-con-python-min.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Aprende a programar en Python</h5>
          <p class="card-text">Nate Gentile</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$350.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>
      
      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/1995678/Qe69BGYXRGqYxVIO1kae_codigo-limpio-del-siglo-xx1.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Código limpio del siglo XXI (Clean code)</h5>
          <p class="card-text">Martin aka BettaTech</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$300.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/2024609/F2TifraHR26mbZmPxsS0_historia-de-la-tarjeta-grafica-min.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Historia de la tarjeta gráfica</h5>
          <p class="card-text">Arturo Alonso Alonso</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$200.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

    </div>
  </section>

  <section class="container-fluid mb-5" data-aos="fade-up">
    <h2 class="text-center fw-bolder">Los cursos mejor vendidos</h2>
    <hr>
    <div class="px-5 owl-carousel owl-theme">
      
      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9" href="#">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/1948561/HVgczjlDQjK5CIXpb57p_desarrollo-web-con-html-css-min.png"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Crea páginas web con HTML y CSS</h5>
          <p class="card-text">Paco Gomez Arnal</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$250.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class='bx bxs-star-half rate-star rating-star'></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/1652554/m8sF2qn5R7WkrFrvDAJe_Seguridad%20pc-min.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Cómo protegerse en la red</h5>
          <p class="card-text">Kike Gandia</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$230.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/557614/hr1BWk5LTF2jiAziFPH0_aprende-a-programar-de-cero-con-python-min.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Aprende a programar en Python</h5>
          <p class="card-text">Nate Gentile</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$350.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>
      
      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/1995678/Qe69BGYXRGqYxVIO1kae_codigo-limpio-del-siglo-xx1.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Código limpio del siglo XXI (Clean code)</h5>
          <p class="card-text">Martin aka BettaTech</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$300.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

      <a href="course-details" class="card my-3 text-decoration-none text-dark" role="button">
        <div class="ratio ratio-16x9">
          <img 
            src="https://import.cdn.thinkific.com/220744/courses/2024609/F2TifraHR26mbZmPxsS0_historia-de-la-tarjeta-grafica-min.jpg"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title">Historia de la tarjeta gráfica</h5>
          <p class="card-text">Arturo Alonso Alonso</p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$200.00 MXN</h6>
          <p>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
            <i class="bx bxs-star rate-star rating-star"></i>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 5 níveles</p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 36 horas</p>
          </div>
        </div>
      </a>

    </div>
  </section>

  <section class="container-fluid bg-secondary mb-5" data-aos="fade-up" id="info-section">
    <div class="row text-light text-center py-5">
      <div class="h4 col-sm-4 col-12 mb-sm-0 mb-5">
        + de
        <p class="h1 fw-bold mb-0">
          <i class='bx bxs-group'></i><span class="counter" data-val="1000">0</span>
        </p>
        alumnos
      </div>
      <div class="h4 col-sm-4 col-12 mb-sm-0 mb-5">
        + de
        <p class="h1 fw-bold mb-0">
          <i class='bx bxs-chalkboard'></i><span class="counter" data-val="500">0</span>
        </p>
        instructores
      </div>
      <div class="h4 col-sm-4 col-12 mb-sm-0 mb-5">
        + de
        <p class="h1 fw-bold mb-0">
          <i class='bx bxs-graduation' ></i><span class="counter" data-val="45">0</span>
        </p>
        cursos
      </div>
    </div>
  </section>

  <section class="container mb-5">
    <div class="row" data-aos="fade-up">
      <div class="col-lg-6 text-lg-start text-center">
        <img 
          src="../client/assets/images/girl-working-on-laptop.svg"
          alt="Girl Working on Laptop"
          class="img-fluid"
        >
      </div>
      <div class="col-lg-6 d-flex flex-column justify-content-center">
        <h3 class="fw-bolder text-center text-lg-start">¡No esperes más!</h3>
        <h4 class="text-center text-lg-start">Desarrolla tus habilidades profesionales con nosotros</h4>
        
        <!-- Sin sesion -->
        <div class="d-flex justify-content-center justify-content-lg-start">
          <a href="signup" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Crea una cuenta gratis!</a>
        </div>
        <!-- Con sesion estudiante --> 
        <!-- <div class="d-flex justify-content-center justify-content-lg-start">
          <a href="search" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Explorar cursos!</a>
        </div> -->
        <!-- Con sesion de instructor -->
        <!-- <div class="d-flex justify-content-center justify-content-lg-start">
          <a href="course-creation" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Crea un curso!</a>
        </div> -->
          
      </div>
    </div>
  </section>

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