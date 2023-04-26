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
  <?= $this->link("styles/pages/home.css") ?>
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
      <?php foreach($this->lastPublishedcourses as $course): ?>
      <a 
        href="course-details?id=<?= $course["id"] ?>" 
        class="card my-3 text-decoration-none text-dark" 
        role="button"
      >
        <div class="ratio ratio-16x9">
          <img 
            src="api/v1/images/<?= $course["imageId"] ?>"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title"><?= $course["title"] ?></h5>
          <p class="card-text"><?= $course["instructorName"] ?></p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$<?= $course["price"] ?> MXN</h6>
          <p>
          <?php if($course["rate"] == 0): ?>
            <span>No hay reseñas</span>
          <?php else: ?>
            <i class="bx <?= $course["rate"] >= 1 ? 'bxs-star': ($course["rate"] >= 0.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 2 ? 'bxs-star': ($course["rate"] >= 1.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 3 ? 'bxs-star': ($course["rate"] >= 2.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 4 ? 'bxs-star': ($course["rate"] >= 3.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 5 ? 'bxs-star': ($course["rate"] >= 4.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <?php endif ?>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 
              <?= $course["levels"] ?> 
              <?= ($course["levels"] == 1) ? 'nivel' : 'niveles' ?>
            </p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 
              <?= $course["videoDuration"] < 1 ? '<1' : round($course["videoDuration"]) ?>
              <?= (round($course["videoDuration"]) <= 1) ? 'hora' : 'horas' ?>
            </p>
          </div>
        </div>
      </a>
      <?php endforeach ?>
    </div>
  </section>

  <section class="container-fluid mb-5" data-aos="fade-up">
    <h2 class="text-center fw-bolder">Los cursos mejor valorados</h2>
    <hr>
    <div class="px-5 owl-carousel owl-theme">
      <?php foreach($this->topRatedCourses as $course): ?>
      <a 
        href="course-details?id=<?= $course["id"] ?>" 
        class="card my-3 text-decoration-none text-dark" 
        role="button"
      >
        <div class="ratio ratio-16x9">
          <img 
            src="api/v1/images/<?= $course["imageId"] ?>"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title"><?= $course["title"] ?></h5>
          <p class="card-text"><?= $course["instructorName"] ?></p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$<?= $course["price"] ?> MXN</h6>
          <p>
          <?php if($course["rate"] == 0): ?>
            <span>No hay reseñas</span>
          <?php else: ?>
            <i class="bx <?= $course["rate"] >= 1 ? 'bxs-star': ($course["rate"] >= 0.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 2 ? 'bxs-star': ($course["rate"] >= 1.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 3 ? 'bxs-star': ($course["rate"] >= 2.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 4 ? 'bxs-star': ($course["rate"] >= 3.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 5 ? 'bxs-star': ($course["rate"] >= 4.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <?php endif ?>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 
              <?= $course["levels"] ?> 
              <?= ($course["levels"] == 1) ? 'nivel' : 'niveles' ?>
            </p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 
              <?= $course["videoDuration"] < 1 ? '<1' : round($course["videoDuration"]) ?>
              <?= (round($course["videoDuration"]) <= 1) ? 'hora' : 'horas' ?>
            </p>
          </div>
        </div>
      </a>
      <?php endforeach ?>
    </div>
  </section>

  <section class="container-fluid mb-5" data-aos="fade-up">
    <h2 class="text-center fw-bolder">Los cursos mejor vendidos</h2>
    <hr>
    <div class="px-5 owl-carousel owl-theme">
      <?php foreach($this->bestSellingCourses as $course): ?>
      <a 
        href="course-details?id=<?= $course["id"] ?>" 
        class="card my-3 text-decoration-none text-dark" 
        role="button"
      >
        <div class="ratio ratio-16x9">
          <img 
            src="api/v1/images/<?= $course["imageId"] ?>"
            class="card-img-top img-cover"
            alt="Curso">
        </div>
        <div class="card-body text-center rounded-bottom">
          <h5 class="card-title"><?= $course["title"] ?></h5>
          <p class="card-text"><?= $course["instructorName"] ?></p>
          <hr>
          <h6 class="card-text mb-0 fw-bold">$<?= $course["price"] ?> MXN</h6>
          <p>
          <?php if($course["rate"] == 0): ?>
            <span>No hay reseñas</span>
          <?php else: ?>
            <i class="bx <?= $course["rate"] >= 1 ? 'bxs-star': ($course["rate"] >= 0.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 2 ? 'bxs-star': ($course["rate"] >= 1.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 3 ? 'bxs-star': ($course["rate"] >= 2.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 4 ? 'bxs-star': ($course["rate"] >= 3.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
            <i class="bx <?= $course["rate"] >= 5 ? 'bxs-star': ($course["rate"] >= 4.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
          <?php endif ?>
          </p>
          <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><i class='bx bxs-layer'></i> 
              <?= $course["levels"] ?> 
              <?= ($course["levels"] == 1) ? 'nivel' : 'niveles' ?>
            </p>
            <p class="mb-0"><i class='bx bxs-time' ></i> 
              <?= $course["videoDuration"] < 1 ? '<1' : round($course["videoDuration"]) ?>
              <?= (round($course["videoDuration"]) <= 1) ? 'hora' : 'horas' ?>
            </p>
          </div>
        </div>
      </a>
      <?php endforeach ?>
    </div>
  </section>

  <section class="container-fluid bg-secondary mb-5" data-aos="fade-up" id="info-section">
    <div class="row text-light text-center py-5">
      <div class="h4 col-sm-4 col-12 mb-sm-0 mb-5">
        + de
        <p class="h1 fw-bold mb-0">
          <i class='bx bxs-group'></i>
          <span class="counter" data-val="<?= $this->stats["students"] ?>">0</span>
        </p>
        alumnos
      </div>
      <div class="h4 col-sm-4 col-12 mb-sm-0 mb-5">
        + de
        <p class="h1 fw-bold mb-0">
          <i class='bx bxs-chalkboard'></i>
          <span class="counter" data-val="<?= $this->stats["instructors"] ?>">0</span>
        </p>
        instructores
      </div>
      <div class="h4 col-sm-4 col-12 mb-sm-0 mb-5">
        + de
        <p class="h1 fw-bold mb-0">
          <i class='bx bxs-graduation' ></i>
          <span class="counter" data-val="<?= $this->stats["courses"] ?>">0</span>
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
      </div>
    </div>
  </section>

  <?= $this->render("partials/footer") ?>
</body>
</html>