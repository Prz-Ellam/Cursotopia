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
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">

  <?= $this->link("styles/pages/search.css") ?>
  <?= $this->script("javascript/search.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>

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
  <?= $this->render("partials/footer") ?>
</body>
</html>