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

  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/812dd4b211.js" crossorigin="anonymous"></script>
  
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <link rel="stylesheet" href="../dist/assets/course-details.css">

  <script defer type="module" src="../dist/javascript/course-details.js"></script>
</head>
<body>
  <?= $this->render("partials/navbar") ?>

  <!-- Main -->
  <main class="my-5 container">
    <section class="row">
      <div class="col-lg-8 col-12">
        <div class="mb-4">
          <h2 class="fw-bold"><?= $this->course["title"] ?></h2>
          <p>Creado por: <a href="profile"><?= $this->course["instructorName"] ?></a></p>
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
      <div class="rounded-3 bg-primary col-lg-4 col-12 p-4 pt-5">
        <h3 class="text-center text-white"><?= $this->course["price"] ?> MXN</h3>
        <!-- Sin comprar -->
        
        <a 
          href="payment-method?courseId=<?= $this->course["id"] ?>" 
          class="btn btn-secondary w-100"
        >
          Comprar este curso
        </a>
        
        <!-- Gratis -->
        <!--         
        <a href="course-visor" class="btn btn-secondary w-100">Conseguir este curso</a>
        -->

        <!-- Comprado -->
        <!--
          <a href="course-visor" class="btn btn-secondary w-100">Reanudar el curso</a>
        -->
        <hr>

        <div class="mb-4">
          <span class="fw-bold rating-star"><?= number_format((float)$this->course["rates"] , 2, '.', '') ?></span>
          <i class="h6 bx bxs-star rating-star"></i>
          <i class="h6 bx bxs-star rating-star"></i>
          <i class="h6 bx bxs-star rating-star"></i>
          <i class="h6 bx bxs-star rating-star"></i>
          <i class="h6 bx bxs-star-half rating-star"></i>
          <a href="#" class="ms-1 text-white"><?= $this->course["reviews"] ?> <?= ($this->course["reviews"] === 1) ? 'reseña' : 'reseñas' ?></a>
        </div>

        <p class="text-white mb-0"><i class="h6 bx bx-time"></i> <?= $this->course["duration"] < 1 ? '<1' : round($this->course["duration"]) ?> <?= (round($this->course["duration"]) <= 1) ? 'hora' : 'horas' ?> de contenido</p>
        <p class="text-white mb-0"><i class="h6 bx bx-layer"></i> <?= $this->course["levels"] ?> <?= ($this->course["levels"] === 1) ? 'nivel' : 'níveles' ?></p>
        <p class="text-white mb-0"><i class="h6 bx bx-group"></i> <?= $this->course["students"] ?> <?= ($this->course["levels"] === 1) ? 'estudiante' : 'estudiantes' ?></p>
        <p class="text-white mb-0">Fecha de creación: <?=  date_format(date_create($this->course["createdAt"]), 'd M Y') ?></p>
        <p class="text-white mb-0">Última actualización: <?= date_format(date_create($this->course["modifiedAt"]), 'd M Y') ?></p>

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

    <?php foreach($this->levels as $i => $level): ?>
      <div class="border-0 card">
        <div role="button" class="<?= ($i === 0) ? 'rounded-top'  : 'rounded-0' ?> bg-light card-header" data-bs-toggle="collapse"
          data-bs-target="#collapse-<?= $level["id"] ?>">
          <i class='bx bx-chevron-down'></i> <?= $level["title"] ?>
        </div>
        <div class="collapse" id="collapse-<?= $level["id"] ?>">
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

    </section>
    <section class="container my-2">
      <form class="p-3" id="create-review-form">
        <div class="pt-4">
          <h2 class="fw-bold text-center">Comentarios</h2>
        </div>
        <hr>
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
        <div class="mt-3 mb-3">
          <textarea class="bg-light form-control rounded-1 border-0 shadow-none" name="message" id="message-box" rows="5"
          placeholder="Escribe un comentario"></textarea>
        </div>
        <button type="submit" class="btn btn-primary rounded-5 border-0 shadow-none mb-4"
          id="send-message">Publicar</button>
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
                    <small class="mb-0">07 mar 2021 8:21</small>
                    <span>
                      <i class="bx <?= $review["rate"] >= 1 ? 'bxs-star': 'bx-star' ?> rating-star"></i>
                      <i class="bx <?= $review["rate"] >= 2 ? 'bxs-star': 'bx-star' ?> rating-star"></i>
                      <i class="bx <?= $review["rate"] >= 3 ? 'bxs-star': 'bx-star' ?> rating-star"></i>
                      <i class="bx <?= $review["rate"] >= 4 ? 'bxs-star': 'bx-star' ?> rating-star"></i>
                      <i class="bx <?= $review["rate"] >= 5 ? 'bxs-star': 'bx-star' ?> rating-star"></i>
                    </span>
                  </div>
                </div>
                <a href="#"
                  class="nav-link"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Eliminar</a></li>
                </ul>
              </div>
              <p class="mb-0">
                <?= $review["message"]  ?>
              </p>
            </div>
          </div>
        </div>
        <?php endforeach ?>

        <!-- <hr class="my-0"> -->

        <div class="d-flex justify-content-center">
          <button class="btn btn-primary w-100 rounded-pill">Mostrar más comentarios</button>
        </div>
      </div>
    </section>



  </main>

  <?= $this->render("partials/footer") ?>
</body>
</html>