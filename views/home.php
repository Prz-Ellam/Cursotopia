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
  <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="../client/styles/pages/home.css">
  <?= $this->script("javascript/home.js") ?>
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
</head>
<body>
  <?= $this->render("partials/navbar") ?>
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
          <div class="d-flex justify-content-lg-start justify-content-center">
            <?php if ($this->id === "NULL"): ?>
            <a href="signup" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Crea una cuenta gratis!</a>
            <?php elseif($this->role === 2): ?>
            <a href="course-creation" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Crea un curso!</a>
            <?php elseif($this->role === 3): ?>
            <a href="search" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Explorar cursos!</a>
            <?php endif ?>
          </div>
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
          <?php if ($this->id === "NULL"): ?>
          <a href="signup" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Crea una cuenta gratis!</a>
          <?php elseif($this->role === 2): ?>
          <a href="course-creation" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Crea un curso!</a>
          <?php elseif($this->role === 3): ?>
          <a href="search" class="btn btn-primary border-0 shadow-none rounded-5 w-50">¡Explorar cursos!</a>
          <?php endif ?>
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

  <?= $this->render("partials/footer") ?>
</body>
</html>