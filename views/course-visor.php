<?php

use Cursotopia\Helpers\Format;
use Cursotopia\Models\EnrollmentModel;

$id = $_SESSION["id"] ?? -1;
$lessonId = $_GET["lesson"] ?? -1;

$result = EnrollmentModel::visitLesson($id, $lessonId);

?>
<!DOCTYPE html>
<html lang="<?= LANG ?>">
<head>
  <meta charset="<?= CHARSET ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->env("APP_NAME") ?></title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">

  <!-- Boxicons --> 
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../client/styles/pages/course-visor.css">
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  
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
        <?php $price = ($this->course["price"] > 0) ?>
        <?php $isPaid = $this->enrollment["isPaid"] ?>
        <?php $levelFree = $this->lesson["levelFree"] ?>

        <?php if ($price && !$isPaid && !$levelFree): ?>

          <h5 class="text-center mt-3">
            <p>Lección bloqueada, es necesario comprar el curso</p>
            <i class="h1 bx bxs-lock-alt" style="font-size: 128px"></i>
          </h5>
        <?php else: ?>
        
        <?php if ($this->lesson["videoId"]): ?>
        <video id="level-video" controls video-id="<?= $this->lesson["videoId"] ?>"></video>
        <?php else: ?>
        <button class="btn btn-primary rounded-pill" id="finish">Finalizar</button>
        <?php endif ?>
        <!--div class="d-flex justify-content-center mt-2">
          <a href="/course-visor" class="btn btn-primary rounded-pill me-2">Anterior</a>
          <a href="/course-visor" class="btn btn-primary rounded-pill">Siguiente</a>
        </div-->
        <p class="mt-3" id="lesson-description">
          <?= Format::sanitize($this->lesson["description"]) ?>
        </p>
        <?php if ($this->lesson["imageId"]): ?>
        <h5 class="mt-3">Imágen</h5>
        <img src="/api/v1/images/<?= $this->lesson["imageId"] ?>" alt="" class="img-fluid">
        <?php endif ?>
        <?php if ($this->lesson["documentId"]): ?>
        <h5 class="mt-3">Documento</h5>
        <div class="d-flex">
          <a href="/api/v1/documents/<?= $this->lesson["documentId"] ?>" target="_blank" class="text-primary d-flex align-items-center text-decoration-none"><i class='bx-sm bx bxs-file-pdf'></i>Archivo PDF</a>
        </div>
        <?php endif ?>
        <?php if ($this->lesson["linkId"]): ?>
        <h5 class="mt-3">Enlace</h5>
        <a href="<?= $this->lesson["linkAddress"] ?>"
          target="_blank" class="text-primary">
          <?= $this->lesson["linkName"] ?>  
        </a>
        <?php endif ?>
        <br><br>
        <?php endif ?>
      </div>
      <div class="col-lg-4 col-sm-12 course-content">

        <h4 class="text-center mt-3">Contenido del curso</h4>

        <div class="accordion" id="accordionPanelsStayOpenExample">
          <?php foreach ($this->levels as $i => $level) : ?>
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading<?= $i ?>">
              <button class="accordion-button collapsed shadow-none bg-white text-black" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?= $i ?>" aria-expanded="true" aria-controls="panelsStayOpen-collapse<?= $i ?>">
                <?= $i + 1 ?> . <?= Format::sanitize($level["title"]) ?>
              </button>
            </h2>
            <div id="panelsStayOpen-collapse<?= $i ?>" class="accordion-collapse collapse <?= ($level["id"] === $this->lesson["levelId"]) ? 'show' : '' ?>" aria-labelledby="panelsStayOpen-heading<?= $i ?>">
              <div class="list-group list-group-flush">
              <?php foreach ($level["lessons"] as $i => $lesson) : ?>
                <a
                  href="/course-visor?course=<?= $this->course["id"] ?>&lesson=<?= $lesson["id"] ?>"
                  class="list-group-item hoverable <?= ($lesson["id"] == $this->lesson["id"]) ? 'selected-course-content' : '' ?>" 
                  role="button"
                >
                  <p class="mb-0 fw-bold d-flex align-items-center">
                    <i class="bx-sm bx <?= $lesson["isComplete"] ? "bxs-checkbox-checked" : "bx-checkbox" ?>"></i>
                    <span><?= $i + 1 ?> . <?= Format::sanitize($lesson["title"]) ?></span>
                  </p>
                  <small class="d-flex align-items-center ms-2 mb-0">
                    <?php if($lesson["mainResource"] == "video"): ?>
                    <i class="bx bxs-video me-2"></i> Video - <?= $lesson["videoDuration"] ?>
                    <?php elseif($lesson["mainResource"] == "image"): ?>
                    <i class="bx bxs-image me-2"></i> Imagen
                    <?php elseif($lesson["mainResource"] == "document"): ?>
                    <i class="bx bxs-file-pdf me-2"></i> Documento
                    <?php elseif($lesson["mainResource"] == "link"): ?>
                    <i class="bx bx-link-alt me-2"></i> Enlace
                    <?php endif ?>
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

  <?= $this->render("partials/footer") ?>
</body>
</html>