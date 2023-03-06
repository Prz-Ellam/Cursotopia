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
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../dist/assets/search.css">
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <script defer type="module" src="../dist/javascript/search.js"></script>
</head>
<body>
  <!-- Navbar -->
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

  <main class="container my-5">
    <h2 class="fw-bold">Resultados de busqueda</h2>
    
    <form class="row" action="#" id="search-form">
      <div class="col-12 mb-4">
        <label for="course-title" class="form-label" role="button">Buscar por título de curso:</label>
        <input type="search" name="title" id="course-title" class="form-control" placeholder="Buscar el nombre de un curso...">
      </div>

      <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
        <label for="categories" role="button">Filtrar por categorías</label>
        <select name="categories" id="categories" class="form-select">
          <option value="0">Seleccionar</option>
          <option value="1">Programación</option>
          <option value="2">Arte</option>
          <option value="3">Cine</option>
        </select>
      </div>
      
      <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
        <label for="instructors" role="button">Filtrar por instructores</label>
        <input type="text" name="instructors" id="instructors" class="form-control" placeholder="Ej. Jon Doe">
      </div>

      <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
        <label for="date-from" role="button">Desde</label>
        <input type="date" name="date-from" id="date-from" class="form-control">
      </div>

      <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
        <label for="date-to" role="button">Hasta</label>
        <input type="date" name="date-to" id="date-to" class="form-control">
      </div>
    </form>
    
    <br>

    <div class="row">

      <article class=" col-12 col-md-6 col-lg-4 mb-5  art1" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://import.cdn.thinkific.com/220744/courses/1948561/HVgczjlDQjK5CIXpb57p_desarrollo-web-con-html-css-min.png" 
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
      </article>

      <article class="col-12 col-md-6 col-lg-4 mb-5 art2" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://import.cdn.thinkific.com/220744/courses/1607512/uQ8vIkXTQitImoVggHwd_GIT_760x420-min.png" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">Git: ¡de Noob a Pro!</h5>
            <p class="card-text">Antonio Sarosi</p>
            <hr>
            <h6 class="card-text mb-0 fw-bold">$110.00 MXN</h6>
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
      </article>

      <article class="col-12 col-md-6 col-lg-4 mb-5 art3" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://import.cdn.thinkific.com/220744/courses/1731834/EeXEBsBaS6mbjU2NP0WX_php-y-la-web-desde-cero-min.jpg" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">Todo sobre la web con PHP</h5>
            <p class="card-text">Antonio Sarosi</p>
            <hr>
            <h6 class="card-text mb-0 fw-bold">$200.00 MXN</h6>
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
      </article>

      <article class="col-12 col-md-6 col-lg-4 mb-5 art1" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://import.cdn.thinkific.com/220744/courses/1839345/gnTVSojSQwu0hZ3JpPfr_aprende-a-porgramar-en-arduino.jpg" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">Introducción a ARDUINO</h5>
            <p class="card-text">Edgar Pons</p>
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
      </article>

      <article class="col-12 col-md-6 col-lg-4 mb-5 art2" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://import.cdn.thinkific.com/220744/courses/740862/pbSjeg4pScuwTN7Y8doE_lenguaje-c-ritchie-min.png" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">El lenguaje de programación C</h5>
            <p class="card-text">Paco Gomez Arnal</p>
            <hr>
            <h6 class="card-text mb-0 fw-bold">$230.00 MXN</h6>
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
      </article>

      <article class="col-12 col-md-6 col-lg-4 mb-5 art3" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://i.ytimg.com/vi/KG8cAGvn9d4/maxresdefault.jpg" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">Crea tu propio motor de juego</h5>
            <p class="card-text">TheCherno</p>
            <hr>
            <h6 class="card-text mb-0 fw-bold">$400.00 MXN</h6>
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
      </article>

      <article class="col-12 col-md-6 col-lg-4 mb-5 art1" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://import.cdn.thinkific.com/220744/courses/1731836/HhNy2ec4SaWUAhdexP2A_aprende-laravel-desde-cero-min.jpg" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">Aprende Laravel desde cero</h5>
            <p class="card-text">Antonio Sarosi</p>
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
      </article>

      <article class="col-12 col-md-6 col-lg-4 mb-5 art2" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://pikuma.com/images/courses/nes.jpg" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">Programación en NES</h5>
            <p class="card-text">Pikuma</p>
            <hr>
            <h6 class="card-text mb-0 fw-bold">$500.00 MXN</h6>
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
      </article>

      <article class="col-12 col-md-6 col-lg-4 mb-5 art3" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://import.cdn.thinkific.com/220744/courses/881985/h20jls3OSdiMYPpYXpJC_Tu%20propio%20entorno%20de%20escritorio%20Arch%20linux-min.jpg" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">Crea tu propio entorno de desarrollo con Linux</h5>
            <p class="card-text">Antonio Sarosi</p>
            <hr>
            <h6 class="card-text mb-0 fw-bold">$290.00 MXN</h6>
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
      </article>

      <article class="col-12 col-md-6 col-lg-4 mb-5 art1" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://pikuma.com/images/courses/2dgameengine.jpg" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">Desarrollo de videojuegos 2D en C++</h5>
            <p class="card-text">Pikuma</p>
            <hr>
            <h6 class="card-text mb-0 fw-bold">$270.00 MXN</h6>
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
      </article>

      <article class="col-12 col-md-6 col-lg-4 mb-5 art2" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://i.ytimg.com/vi/45MIykWJ-C4/maxresdefault.jpg" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">Aprende todo de OpenGL</h5>
            <p class="card-text">Bryan Duarte</p>
            <hr>
            <h6 class="card-text mb-0 fw-bold">$190.00 MXN</h6>
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
      </article>

      <article class="col-12 col-md-6 col-lg-4 mb-5 art3" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img src="https://www.freecodecamp.org/news/content/images/2023/01/ue3.png" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">Aprende Unreal Engine 5</h5>
            <p class="card-text">Roberto Flores</p>
            <hr>
            <h6 class="card-text mb-0 fw-bold">$430.00 MXN</h6>
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
      </article>

      <!--
      <article class="col-12 col-md-6 col-lg-4 mb-5 d-flex " id="art3" data-aos="fade-up">
        <div class="card bg-light border-0 mx-auto">
          <div class="ratio ratio-16x9">
            <img src="https://import.cdn.thinkific.com/220744/courses/1948561/HVgczjlDQjK5CIXpb57p_desarrollo-web-con-html-css-min.png" 
              class="card-img-top img-cover"
              alt="Curso">
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title">Crea páginas web con HTML y CSS y JS</h5>
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
        </div>
      </article>
      -->
      
      <div class="d-flex justify-content-center" aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#"><i class='bx bx-chevron-left'></i></a></li>
          <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#">1</a></li>
          <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#">2</a></li>
          <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#">3</a></li>
          <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#"><i class='bx bx-chevron-right'></i></a></li>
        </ul>
      </div>
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