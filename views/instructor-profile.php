<?php

use Cursotopia\Repositories\CategoryRepository;
use Cursotopia\Repositories\CourseRepository;

$categoryId = $_GET["category_id"] ?? null;
$from = $_GET["from"] ?? null;
$to = $_GET["to"] ?? null;

if ($categoryId || $categoryId === "") {
  if (!((is_int($categoryId) || ctype_digit($categoryId)) && (int)$categoryId > 0)) {
    $categoryId = null;
  }
}

function validarFormatoFecha($fecha) {
  $d = DateTime::createFromFormat('Y-m-d', $fecha);
  return $d && $d->format('Y-m-d') === $fecha;
}

if (!$from || !validarFormatoFecha($from)) {
  $from = null;
}

if (!$to || !validarFormatoFecha($to)) {
  $to = null;
}

$courseRepository = new CourseRepository();
$courses = $courseRepository->instructorCoursesFindAllByInstructorId(
  $this->session("id"),
  $categoryId,
  $from,
  $to
);

$categoryRepository = new CategoryRepository();
$categories = $categoryRepository->findAll();

?>
<main>
  <!-- Hero -->
  <div class="container-fluid bg-tertiary shadow-sm">
    <div class="row p-4">
      <div class="text-center col-xl-2 col-md-4 col-sm-5 col-xs-12">
      <img src="api/v1/images/<?= $this->user["profilePicture"] ?>" class="img-hero" width="180" height="180" alt="Foto de perfil">
      </div>
      <div class="col-xl-10 col-md-8 col-sm-7 col-xs-12 m-auto">
        <div class="container text-xs-center">
          <div class="row">
            <div class="col-12">
              <h3 class="fw-bold">
                <?= $this->user["name"] ?> <?= $this->user["lastName"] ?>
              </h3>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <h6><?= $this->user["email"] ?></h6>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <h6><?= date_format(date_create($this->user["birthDate"]), 'd M Y') ?></h6>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12">
              <a href="profile-edition" class="btn btn-secondary shadow-none border-0 rounded-5">
                Editar perfil
              </a>
              <a href="password-edition" class="btn btn-secondary shadow-none border-0 rounded-5">
                Cambiar contraseña</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contenido -->
  <div class="container">
    <h2 class="fw-bold mt-4">Mis cursos</h2>
    <h4 class="mt-3">Filtros</h4>
    <form class="row" action="" method="GET">
      <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
      <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-4 select-date">
        <label for="from" class="col-auto col-form-label" role="button">
          Fecha inicial:
        </label>
        <input type="date" value="<?= $from ?? "" ?>" name="from" 
          class="col-auto form-control w-50" id="from">
      </div>
      <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-4 select-date">
        <label for="to" class="col-auto col-form-label" role="button">
          Fecha final:
        </label>
        <input type="date" value="<?= $to ?? "" ?>" name="to" 
          class="col-auto form-control w-50" id="to">
      </div>

      <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-4 select-box">
        <label for="" class="col-auto col-form-label">Categoria:</label>
        <select name="category_id" class="col-auto form-select w-50">
          <option value="" selected>Categorias</option>
          <?php foreach ($categories as $category) : ?>
            <option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4  mt-3 ">
        <div class="form-check form-check-inline">
          <input class="form-check-input" name="actives" type="checkbox" id="inlineCheckbox2" value="true">
          <label class="form-check-label" for="inlineCheckbox2">Solo activos</label>
        </div>
      </div>

      <input type="submit" value="Buscar">

    </form>

    <!-- Cards -->
    <div class="container mt-4">
      <?php foreach($courses as $course): ?>
      <div data-aos="fade-up">
        <div class="card mb-4 bg-light border-0">
          <div class="row g-0">
            <div class="col-md-4">
              <div class="ratio ratio-16x9 h-100">
                <img 
                  src="api/v1/images/<?= $course["imageId"] ?>" 
                  class="img-cover img-fluid rounded-start" 
                  alt="Portada del curso">
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h4 class="card-title"><?= $course["title"] ?></h4>
                <hr>
                <p class="d-flex align-items-center card-text mb-0">
                  <i class="bx bxs-group me-1"></i>
                  <span>Cantidad de alumnos: <?= $course["enrollments"] ?></span>
                </p>
                <p class="d-flex align-items-center card-text mb-0">
                  <i class="bx bx-money me-1"></i>
                  <span>Total de ingresos: $<?= $course["amount"] ?> MXN</span>
                </p>
                <p class="d-flex align-items-center card-text mb-1">
                  <i class="bx bxs-layer me-1"></i>
                  <span>Nivel promedio: <?= $course["averageLevel"] ?>%</span> 
                </p>
                <div class="progress mb-3">
                  <div class="progress-bar bg-primary" role="progressbar" 
                    style="width: <?= $course["averageLevel"] ?>%"
                    aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" 
                    aria-valuemax="100">
                  </div>
                </div>
                <a 
                  href="instructor-course-details?course_id=<?= $course["id"] ?>" 
                  class="btn btn-secondary rounded-5 border-0 shadow-none">
                  Ver detalles de curso
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach ?>

      <div class="d-flex justify-content-center mt-5" aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#"><i class='bx bx-chevron-left'></i></a></li>
          <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#">1</a></li>
          <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#">2</a></li>
          <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#">3</a></li>
          <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#"><i class='bx bx-chevron-right'></i></a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- TODO: Total de ingresos por curso -->

  <div class="container mb-4">
    <div class="row pt-4 pb-3">
      <div class="col-lg-12">
        <h4 class="ms-5">Total de ingresos</h4>
      </div>
    </div>
    <div class="row ms-5 pe-4">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Método de pago</th>
            <th scope="col">Total de ingresos</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Tarjeta de crédito/débito</th>
            <td>$1,000.00 MXN</td>
          </tr>
          <tr>
            <th scope="row">Paypal</th>
            <td>$500.00 MXN</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</main>