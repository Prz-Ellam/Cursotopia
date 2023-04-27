<?php

use Cursotopia\Models\EnrollmentModel;

$id = $_SESSION["id"] ?? -1;
$lessonId = $_GET["id"] ?? -1;

EnrollmentModel::visitLesson($id, $lessonId);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->env("APP_NAME") ?></title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../client/styles/pages/course-visor.css">
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">

  <?= $this->script("javascript/course-visor.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>
  <!-- Main -->
  <main class="container-fluid">
    <div class="row mb-3">
      <div class="col-lg-8 col-sm-12 course-content mb-5">
        <h4 class="mt-3">Introducción y conocimientos previos</h4>
        
        <div id="video-container">

        </div>
        <video id="level-video" controls src="api/v1/videos/<?= $this->lesson["videoId"] ?>">
          
        </video>
        <div class="d-flex justify-content-center mt-2">
          <a href="course-visor" class="btn btn-primary rounded-pill me-2">Anterior</a>
          <a href="course-visor" class="btn btn-primary rounded-pill">Siguiente</a>
        </div>
        <p class="mt-3" id="lesson-description">
          <?= $this->lesson["description"] ?>
        </p>
        <?php if ($this->lesson["imageId"]): ?>
        <h5 class="mt-3">Imágen</h5>
        <img src="../client/assets/images/city.jpg" alt="" class="img-fluid">
        <?php endif ?>
        <?php if ($this->lesson["documentId"]): ?>
        <h5 class="mt-3">Documento</h5>
        <div class="d-flex">
          <a href="#" class="text-primary d-flex align-items-center text-decoration-none"><i class='bx-sm bx bxs-file-pdf'></i>Archivo PDF</a>
        </div>
        <?php endif ?>
        <?php if ($this->lesson["linkId"]): ?>
        <h5 class="mt-3">Enlace</h5>
        <a href="https://www.google.com" class="text-primary">Nombre del enlace</a>
        <?php endif ?>
        <br><br>
      </div>
      <div class="col-lg-4 col-sm-12 course-content">

        <h4 class="text-center mt-3">Contenido del curso</h4>

        <div class="accordion" id="accordionPanelsStayOpenExample">
          <?php foreach ($this->levels as $i => $level) : ?>
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading<?= $i ?>">
              <button class="accordion-button collapsed shadow-none bg-white text-black" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?= $i ?>" aria-expanded="true" aria-controls="panelsStayOpen-collapse<?= $i ?>">
                <?= $i + 1 ?> . <?= $level["title"] ?>
              </button>
            </h2>
            <div id="panelsStayOpen-collapse<?= $i ?>" class="accordion-collapse collapse <?= ($level["id"] === $this->lesson["levelId"]) ? 'show' : '' ?>" aria-labelledby="panelsStayOpen-heading<?= $i ?>">
              <div class="list-group list-group-flush">
              <?php foreach ($level["lessons"] as $i => $lesson) : ?>
                <a
                  href="course-visor?course=<?= $this->course ?>&lesson=<?= $lesson["id"] ?>"
                  class="list-group-item hoverable <?= ($lesson["id"] == $this->lesson["id"]) ? 'selected-course-content' : '' ?>" 
                  role="button"
                >
                  <p class="mb-0 fw-bold d-flex align-items-center">
                    <i class="bx-sm bx <?= $lesson["is_complete"] ? "bxs-checkbox-checked" : "bx-checkbox" ?>"></i>
                    <span><?= $i + 1 ?> . <?= $lesson["title"] ?></span>
                  </p>
                  <small class="d-flex align-items-center ms-2 mb-0">
                    <i class="bx bxs-video me-2"></i> Video - <?= $lesson["video_duration"] ?>
                  </small>
                </a>
              <?php endforeach ?>
              </div>
            </div>
          </div>
          <?php endforeach ?>
        </div>

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
                <i class='text-primary bx-sm bx bxl-instagram-alt me-2'></i>Instagram
              </a>
            </li>
            <li class="my-2">
              <a href="tel:(00)00000000" class="d-flex justify-content-md-start justify-content-center text-primary text-decoration-none">
                <i class='text-primary bx-sm bx bxs-phone me-2'></i>(00)-0000-0000
              </a>
            </li>
            <li class="my-2">
              <a href="mailto:cursotopia@gmail.com.mx" class="d-flex justify-content-md-start justify-content-center text-primary text-decoration-none">
                <i class='text-primary bx-sm bx bxs-envelope me-2'></i>Correo electrónico
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