<?php
  use Cursotopia\Helpers\Format;
?>
<!DOCTYPE html>
<html lang="<?= LANG ?>">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->env("APP_NAME") ?></title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?= $this->link("styles/pages/search.css") ?>
  <?= $this->script("javascript/search.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>

  <main class="container my-5">
    <h2 class="fw-bold">Resultados de busqueda</h2>
    <form class="row" action="" id="search-form">
      <div class="col-12 mb-4">
        <label for="course-title" class="form-label" role="button">Buscar por título de curso:</label>
        <input type="search" name="title" id="course-title" 
          value="<?= $this->title ?>" 
          class="form-control" placeholder="Buscar el nombre de un curso...">
      </div>

      <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
        <label for="categories" role="button">Filtrar por categorías</label>
        <select name="category" id="categories" class="form-select">
          <option value="">Seleccionar</option>
          <?php foreach($this->categories as $category): ?>
          <option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
          <?php endforeach ?>
        </select>
      </div>
      
      <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
        <label for="instructors" role="button">Filtrar por instructor</label>
        <input type="text" name="instructor_name" id="instructors"
          value="<?= $_GET["instructor_name"] ?? "" ?>"
          class="form-control" placeholder="Ej. Jon Doe">
        <input type="hidden" name="instructor" id="instructor" 
          value="<?= ($this->instructorId == "NULL") ? "" : $this->instructorId ?>">
      </div>

      <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
        <label for="start-date" role="button">Desde</label>
        <input type="date" name="start_date" id="start-date" 
          value="<?= $this->startDate ?>"
          class="form-control">
      </div>

      <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
        <label for="end-date" role="button">Hasta</label>
        <input type="date" name="end_date" id="end-date" 
          value="<?= $this->endDate ?>"
          class="form-control">
      </div>

      <div class="d-grid">
        <input type="submit" value="Buscar" class="btn btn-primary rounded-pill">
      </div>
    </form>
    
    <br>

    <div class="row">

      <?php foreach($this->courses as $i => $course): ?>
      <article class=" col-12 col-md-6 col-lg-4 mb-5 art<?= ($i % 3) + 1 ?>" data-aos="fade-up">
        <a href="course-details?id=<?= $course["id"] ?>" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img 
              src="api/v1/images/<?= $course["imageId"] ?>" 
              class="card-img-top img-cover"
              alt="Curso"
            >
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title"><?= $course["title"] ?></h5>
            <p class="card-text"><?= $course["instructorName"] ?></p>
            <hr>
            <h6 class="card-text mb-0 fw-bold"><?= Format::money($course["price"]) ?></h6>
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
                <?= Format::pluralize($course["levels"], "nivel", "niveles") ?>
              </p>
              <p class="mb-0"><i class="bx bxs-time"></i> 
                <?= Format::hours($course["videoDuration"]) ?>
              </p>
            </div>
          </div>
        </a>
      </article>
      <?php endforeach ?>

      <div class="d-flex justify-content-center" aria-label="Page navigation example">
        <?php $queryParams = $_GET ?>
        <ul class="pagination">
          <?php
            $isFirstPage = $this->page <= 1;
            $queryParams["page"] = $this->page - 1;
            $prevLink = "?" . http_build_query($queryParams);
          ?>
          <li class="page-item <?= $isFirstPage ? "disabled" : "" ?>">
            <a class="page-link border-0 bg-light shadow-none" 
              href="<?= !$isFirstPage ? $prevLink : "" ?>"
            >
              <i class="bx bx-chevron-left"></i>
            </a>
          </li>

          <?php for($i = 1; $i <= $this->totalButtons; $i++): ?>
          <li class="page-item <?= ($i == $this->page) ? "disabled" : "" ?>">
            <?php $queryParams["page"] = $i; ?>
            <a class="page-link border-0 bg-light shadow-none" 
              href="?<?= http_build_query($queryParams) ?>">
              <?= $i ?>
            </a>
          </li>
          <?php endfor ?>

          <?php if ($this->totalPages > $this->totalButtons): ?>
          <li class="page-item disabled">
            <a class="page-link border-0 bg-light shadow-none">
              ...
            </a>
          </li>
          <li class="page-item <?= ($this->totalPages == $this->page) ? "disabled" : "" ?>">
          <?php $queryParams["page"] = $this->totalPages; ?>
            <a class="page-link border-0 bg-light shadow-none" 
              href="?<?= http_build_query($queryParams) ?>">
              <?= $this->totalPages ?>
            </a>
          </li>
          <?php endif ?>

          <li class="page-item <?= ($this->page + 1 > $this->totalPages) ? "disabled" : "" ?>">
            <?php $queryParams["page"] = $this->page + 1; ?>
            <a class="page-link border-0 bg-light shadow-none"
              href="?<?= ($this->page + 1 <= $this->totalPages) ? http_build_query($queryParams) : '' ?>"
            >
              <i class='bx bx-chevron-right'></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </main>
  <?= $this->render("partials/footer") ?>
</body>
<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</html>