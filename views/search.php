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
          <?php foreach($this->categories as $category): ?>
          <option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
          <?php endforeach ?>
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

      <?php foreach($this->courses as $i => $course): ?>
      <article class=" col-12 col-md-6 col-lg-4 mb-5 art<?= ($i % 3) + 1 ?>" data-aos="fade-up">
        <a href="course-details" class="card bg-light border-0 mx-auto text-decoration-none text-dark">
          <div class="ratio ratio-16x9">
            <img 
              src="api/v1/images/<?= $course["imageId"] ?>" 
              class="card-img-top img-cover"
              alt="Curso"
            >
          </div>
          <div class="card-body text-center rounded-bottom">
            <h5 class="card-title"><?= $course["title"] ?></h5>
            <p class="card-text"><?= $course["instructor"] ?></p>
            <hr>
            <h6 class="card-text mb-0 fw-bold">$<?= $course["price"] ?> MXN</h6>
            <p>
              <?php if($course["rates"] == "No reviews"): ?>
              <span>No hay reseñas</span>
              <?php else: ?>
              <i class="bx <?= $course["rates"] >= 1 ? 'bxs-star': ($course["rates"] >= 0.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
              <i class="bx <?= $course["rates"] >= 2 ? 'bxs-star': ($course["rates"] >= 1.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
              <i class="bx <?= $course["rates"] >= 3 ? 'bxs-star': ($course["rates"] >= 2.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
              <i class="bx <?= $course["rates"] >= 4 ? 'bxs-star': ($course["rates"] >= 3.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
              <i class="bx <?= $course["rates"] >= 5 ? 'bxs-star': ($course["rates"] >= 4.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
              <?php endif ?>
            </p>
            <div class="d-flex justify-content-between mb-0">
              <p class="mb-0"><i class='bx bxs-layer'></i> 
                <?= $course["levels"] ?> 
                <?= ($course["levels"] == 1) ? 'nivel' : 'niveles' ?>
              </p>
              <p class="mb-0"><i class='bx bxs-time' ></i> 
                <?= $course["duration"] < 1 ? '<1' : round($course["duration"]) ?>
                <?= (round($course["duration"]) <= 1) ? 'hora' : 'horas' ?>
              </p>
            </div>
          </div>
        </a>
      </article>
      <?php endforeach ?>

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