<?php

use Cursotopia\Helpers\Format;

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
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/812dd4b211.js" crossorigin="anonymous"></script>
  

  <?= $this->link("styles/pages/course-details.css") ?>
  <?= $this->script("javascript/course-details.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>

  <main class="container my-5 ">
    <section class="row">
      <div class="col-lg-8 col-12">
        <div class="mb-4">
          <input id="course-id" type="hidden" value=<?= $this->course["id"] ?>>
          <h2 class="fw-bold"><?= $this->course["title"] ?></h2>
          <p>Creado por: <a href="profile?id=<?= $this->course["instructorId"] ?>">
            <?= $this->course["instructorName"] ?></a>
          </p>
        </div>
        <div class="ratio ratio-16x9 mb-4">
          <img 
            src="api/v1/images/<?= $this->course["imageId"] ?>" 
            alt="Curso"
            class="img-cover">
        </div>

        <h2 class="fw-bold">Descripción</h2>
        <p class="justify-text"><?= $this->course["description"] ?></p>
      </div>
      <div class="bg-primary rounded-3 col-12 col-lg-4 px-4 pt-5">
        <h3 class="text-center text-white">
          <?= Format::money($this->course["price"]) ?>
        </h3>
        <!--
          $free - El curso es completamente gratis
          $demo - El curso tiene algunos niveles gratis
          $enroll - El usuario adquirio el curso (ya sea prueba o completo)
          $isPaid - El usuario adquirio el curso completo
        -->
        <?php if($this->session("role") === 3): ?>
        <?php $free = intval($this->course["price"] <= 0) ?>
        <?php $demo = $this->course["levelFree"] ?? null ?>
        <?php $enroll = !is_null($this->enrollment) ?>
        <?php $isPaid = $this->enrollment["isPaid"] ?? null ?>

        <!-- El curso es gratis -->
        <?php if ($free && !$enroll): ?>
          <button class="btn btn-secondary w-100 my-1" id="enroll">
            Conseguir este curso
          </button>
        <?php endif ?>

        <!-- El curso es gratis y lo adquirio --> 
        <?php if ($free && $enroll): ?>
          <a
            href="course-visor?course=<?= $this->course["id"] ?? "" ?>&lesson=<?= $this->lesson["id"] ?? "" ?>"  
            class="btn btn-secondary w-100 my-1">
            Reanudar este curso
          </a>
        <?php endif ?>

        <!-- El curso tiene prueba gratuita -->
        <?php if(!$free && $demo && !$enroll && !$isPaid): ?>
          <button class="btn btn-secondary w-100 my-1" id="enroll">
            Obtener prueba gratuita
          </button>
          <a 
            href="payment-method?courseId=<?= $this->course["id"] ?? "" ?>" 
            class="btn btn-secondary w-100 my-1">
            Comprar este curso
          </a>
        <?php endif ?>

        <?php if(!$free && $demo && $enroll && !$isPaid): ?>
          <a
            href="course-visor?course=<?= $this->course["id"] ?? "" ?>&lesson=<?= $this->lesson["id"] ?? "" ?>"  
            class="btn btn-secondary w-100 my-1">
            Reanudar prueba gratuita
          </a>
          <a 
            href="payment-method?courseId=<?= $this->course["id"] ?? "" ?>" 
            class="btn btn-secondary w-100 my-1">
            Comprar este curso
          </a>
        <?php endif ?>

        <!-- El curso tiene prueba gratuita y esta pagado -->
        <?php if (!$free && $demo && $enroll && $isPaid): ?>
          <a
            href="course-visor?course=<?= $this->course["id"] ?? "" ?>&lesson=<?= $this->lesson["id"] ?? "" ?>"  
            class="btn btn-secondary w-100 my-1">
            Reanudar este curso
          </a>
        <?php endif ?>

        <?php if (!$free && !$demo && !$enroll && !$isPaid): ?>
          <a 
            href="payment-method?courseId=<?= $this->course["id"] ?? "" ?>" 
            class="btn btn-secondary w-100 my-1">
            Comprar este curso
          </a>
        <?php endif ?>

        <?php if (!$free && !$demo && $enroll && $isPaid): ?>
          <a
            href="course-visor?course=<?= $this->course["id"] ?? "" ?>&lesson=<?= $this->lesson["id"] ?? "" ?>"  
            class="btn btn-secondary w-100 my-1">
            Reanudar este curso
          </a>
        <?php endif ?>
        <?php endif ?>

        <hr>

        <!--
          Case              No se ha enrolado     Enrolado gratis     Enrolado paga
          De paga 100%      Comprar               N/A                 Reanudar
          De paga parcial   Comprar / Prueba      Comprar / Reanudar  Reanudar
          Gratis            Conseguir             Reanudar            N/A
        -->
        
        <div class="mb-4">
          <span class="fw-bold rating-star">
            <?= Format::decimal($this->course["rates"]) ?>
          </span>
          <?php if ($this->course["rates"] !== "No hay reseñas"): ?>
          <i class="bx <?= $this->course["rates"] >= 1 ? 'bxs-star': ($this->course["rates"] >= 0.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
          <i class="bx <?= $this->course["rates"] >= 2 ? 'bxs-star': ($this->course["rates"] >= 1.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
          <i class="bx <?= $this->course["rates"] >= 3 ? 'bxs-star': ($this->course["rates"] >= 2.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
          <i class="bx <?= $this->course["rates"] >= 4 ? 'bxs-star': ($this->course["rates"] >= 3.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
          <i class="bx <?= $this->course["rates"] >= 5 ? 'bxs-star': ($this->course["rates"] >= 4.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
          <?php endif ?>
          <a href="#reviews" class="ms-1 text-white">
            <?= Format::pluralize($this->course["reviews"], 'reseña') ?>
          </a>
        </div>

        <p class="text-white mb-0">
          <i class="h6 bx bx-time"></i>
          <?= Format::hours($this->course["duration"]) ?> de contenido
        </p>

        <p class="text-white mb-0">
          <i class="h6 bx bx-layer"></i>
          <?= Format::pluralize($this->course["levels"], 'nivel', 'níveles') ?>
        </p>

        <p class="text-white mb-0">
          <i class="h6 bx bx-group"></i>
          <?= Format::pluralize($this->course["students"], 'estudiante') ?>
        </p>

        <p class="text-white mb-0">Fecha de creación: <?= Format::date($this->course["createdAt"]) ?></p>
        <p class="text-white mb-0">Última actualización: <?= Format::date($this->course["modifiedAt"]) ?></p>

        <h3 class="mt-4 text-white text-center">Categorías</h3>
        <?php foreach($this->categories as $category):  ?>
        <a
          href="search"
          class="badge bg-dark p-2 text-white rounded-pill text-decoration-none mb-3"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          data-bs-title="<?= $category["description"] ?>"
        >
          <?= $category["name"] ?>
        </a>
        <?php endforeach ?>
      </div>
    </section>

    <section class="container my-5">
      <h2 class="fw-bold text-center">Contenido del curso</h2>
      <div class="accordion" id="course-content">
        <?php foreach($this->levels as $i => $level): ?>
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-<?= $level["id"] ?>">
            <button class="accordion-button shadow-none text-black collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $level["id"] ?>" aria-expanded="false" aria-controls="collapse-<?= $level["id"] ?>">
              <i class='bx bx-chevron-down'></i> <?= $level["title"] ?>
            </button>
          </h2>
          <div id="collapse-<?= $level["id"] ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $level["id"] ?>" data-bs-parent="#course-content">
            <ul class="list-group list-group-flush">
              <?php foreach ($level["lessons"] as $lesson): ?>
              <li class="list-group-item d-flex justify-content-between">
                <span>
                  <i class='bx bxs-video'></i> <?= $lesson["title"] ?>
                </span>
                <span>
                  <?= $lesson["video_duration"] ?>
                </span>
              </li>
              <?php endforeach ?>
            </ul>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </section>

    <section class="container" id="reviews">
      <form class="p-3" id="create-review-form">
        <div class="pt-4">
          <h2 class="fw-bold text-center">Comentarios</h2>
        </div>
        <hr>
        <?php if ($this->session("role") === 3): ?>
        <div>
          <label>Calificación: </label>
          <div class="rating d-inline">
            <i class="bx bx-star rate-star rating-star" star="1"></i>
            <i class="bx bx-star rate-star rating-star" star="2"></i>
            <i class="bx bx-star rate-star rating-star" star="3"></i>
            <i class="bx bx-star rate-star rating-star" star="4"></i>
            <i class="bx bx-star rate-star rating-star" star="5"></i>
          </div>
        </div>
        <input type="hidden" name="rate" id="rate" class="form-control" value="">
        <input type="hidden" name="userId" id="userId" class="form-control" value="<?= $_SESSION["id"] ?>">
        <div class="mt-3 mb-3">
          <textarea class="bg-light form-control rounded-1 border-0 shadow-none" name="message" id="message-box" rows="5"
          placeholder="Escribe un comentario"></textarea>
        </div>
        <div class="d-grid mb-4">
          <button type="submit" class="btn btn-primary rounded-pill d-flex justify-content-center gap-2"
          id="review-create-btn">
          <div class="spinner d-none" id="review-create-spinner"></div>
          <span>Publicar</span>
        </button>
        </div>
        <?php endif ?>
        <div id="comment-section"></div>
      </form>
    </section>

    <section class="container">
      <h4 class="mb-4">Comentarios recientes</h4>
      <div id="review-section">

        <?php foreach($this->reviews as $review): ?>
        <div class="card-body p-4">
          <div class="d-flex flex-start">
            <img
              class="rounded-circle me-3" 
              src="api/v1/images/<?= $review["profilePicture"] ?>"
              alt="avatar" width="60" height="60" />
            <div>
              <div class="d-flex justify-content-between">
                <div>
                  <a class="fw-bold mb-1"><?= $review["userName"] ?></a>
                  <div class="d-flex align-items-center mb-1 gap-2">
                    <small class="mb-0"><?= date('d M Y g:i', strtotime($review["createdAt"])) ?></small>
                    <span>
                      <i class="bx <?= $review["rate"] >= 1 ? 'bxs-star': 'bx-star' ?> rating-star"></i>
                      <i class="bx <?= $review["rate"] >= 2 ? 'bxs-star': 'bx-star' ?> rating-star"></i>
                      <i class="bx <?= $review["rate"] >= 3 ? 'bxs-star': 'bx-star' ?> rating-star"></i>
                      <i class="bx <?= $review["rate"] >= 4 ? 'bxs-star': 'bx-star' ?> rating-star"></i>
                      <i class="bx <?= $review["rate"] >= 5 ? 'bxs-star': 'bx-star' ?> rating-star"></i>
                    </span>
                  </div>
                </div>
                <?php if($this->session("role") == 1 || $this->session("id") == $review["userId"]): ?>
                <a href="#"
                  class="nav-link"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item delete-review" reviewId="<?= $review["id"] ?>">Eliminar</a></li>
                </ul>
                <?php endif ?>
              </div>
              <p class="mb-0">
                <?= $review["message"]  ?>
              </p>
            </div>
          </div>
        </div>
        <hr>
        <?php endforeach ?>

        <!-- <hr class="my-0"> -->

        
      </div>
      <div class="d-grid">
          <button id="show-more-comments" class="btn btn-primary w-100 rounded-pill" data-user-rol="<?= $this->session("role") ?>" data-user-id="<?=  $this->session("id") ?>">Mostrar más comentarios</button>
      </div>
    </section>
  </main>

  <?= $this->render("partials/footer") ?>
</body>
</html>