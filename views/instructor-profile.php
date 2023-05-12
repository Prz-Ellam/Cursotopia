<?php

use Cursotopia\Helpers\Format;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\CourseModel;
use Cursotopia\Repositories\CategoryRepository;
use Cursotopia\Repositories\CourseRepository;

$userId = $_GET["id"] ?? -1;
$categoryId = $_GET["category"] ?? null;
$startDate = $_GET["start_date"] ?? null;
$endDate = $_GET["end_date"] ?? null;
$active = $_GET["active"] ?? 0;
$page = $_GET["page"] ?? 1;

$perPageElement = 6;
$start = ($page - 1) * $perPageElement;

$limit = $perPageElement;
$offset = $start;

if (!Validate::uint($categoryId)) {
  $categoryId = null;
}

if (!Validate::date($startDate)) {
  $startDate = null;
}

if (!Validate::date($endDate)) {
  $endDate = null;
}

$total = CourseModel::salesReportTotal(
  $this->session("id"),
  $categoryId,
  $startDate,
  $endDate,
  $active
);

$totalPages = ceil($total / $perPageElement);
$totalButtons = $totalPages > 5 ? 5 : $totalPages;

$courses = CourseModel::salesReport(
  $this->session("id"),
  $categoryId,
  $startDate,
  $endDate,
  $active,
  $limit,
  $offset
);

$categoryRepository = new CategoryRepository();
$categories = $categoryRepository->findAll();

$courseRepository = new CourseRepository();
$totalRevenue = $courseRepository->instructorTotalRevenueReport($userId);
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
              <h6><?= Format::date($this->user["birthDate"]) ?></h6>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12">
              <a href="/profile-edition" class="btn btn-secondary shadow-none border-0 rounded-5">
                Editar perfil
              </a>
              <a href="/password-edition" class="btn btn-secondary shadow-none border-0 rounded-5">
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
      <!-- Este es para que el campo id no desaparezca en la requests --> 
      <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
      <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-4 select-date">
        <label for="start-date" class="col-auto col-form-label" role="button">
          Fecha inicial:
        </label>
        <input type="date" value="<?= $startDate ?? "" ?>" name="start_date" 
          class="col-auto form-control w-50" id="start-date">
      </div>
      <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-4 select-date">
        <label for="end-date" class="col-auto col-form-label" role="button">
          Fecha final:
        </label>
        <input type="date" value="<?= $endDate ?? "" ?>" name="end_date" 
          class="col-auto form-control w-50" id="end-date">
      </div>

      <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-4 select-box">
        <label for="category" class="col-auto col-form-label" role="button">
          Categoria:
        </label>
        <select name="category" id="category" class="col-auto form-select w-50">
          <option value="" selected>Categorias</option>
          <?php foreach ($categories as $category) : ?>
            <option value="<?= $category["id"] ?>"
              <?= ($category["id"] == $categoryId) ? "selected" : "" ?>>
              <?= $category["name"] ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4  mt-3 ">
        <div class="form-check form-check-inline">
          <input class="form-check-input" name="active" type="checkbox" id="active" 
          value="1" <?= $_GET["active"] ?? "" ? "checked": "" ?>>
          <label class="form-check-label" for="active">Solo activos</label>
        </div>
      </div>

      <div class="d-grid mt-2">
        <button type="submit" class="btn btn-primary rounded-pill">Buscar</button>
      </div>
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
                  <span>Total de ingresos: <?= Format::money($course["amount"]) ?></span>
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
                  href="/instructor-course-details?course_id=<?= $course["id"] ?>" 
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
        <?php $queryParams = $_GET ?>
        <ul class="pagination">
        <?php
            $isFirstPage = $page <= 1;
            $queryParams["page"] = $page - 1;
            $prevLink = "?" . http_build_query($queryParams);
          ?>
          <li class="page-item <?= $isFirstPage ? "disabled" : "" ?>">
            <a class="page-link border-0 bg-light shadow-none" 
              href="<?= !$isFirstPage ? $prevLink : "" ?>"
            >
              <i class="bx bx-chevron-left"></i>
            </a>
          </li>

          
          <?php for($i = 1; $i <= $totalButtons; $i++): ?>
          <li class="page-item <?= ($i == $page) ? "disabled" : "" ?>">
            <?php $queryParams["page"] = $i; ?>
            <a class="page-link border-0 bg-light shadow-none" 
              href="?<?= http_build_query($queryParams) ?>">
              <?= $i ?>
            </a>
          </li>
          <?php endfor ?>

          <?php if ($totalPages > $totalButtons): ?>
          <li class="page-item disabled">
            <a class="page-link border-0 bg-light shadow-none">
              ...
            </a>
          </li>
          <li class="page-item <?= ($totalPages == $page) ? "disabled" : "" ?>">
          <?php $queryParams["page"] = $totalPages; ?>
            <a class="page-link border-0 bg-light shadow-none" 
              href="?<?= http_build_query($queryParams) ?>">
              <?= $totalPages ?>
            </a>
          </li>
          <?php endif ?>

          <li class="page-item <?= ($page + 1 > $totalPages) ? "disabled" : "" ?>">
            <?php $queryParams["page"] = $page + 1; ?>
            <a class="page-link border-0 bg-light shadow-none"
              href="?<?= ($page + 1 <= $totalPages) ? http_build_query($queryParams) : '' ?>"
            >
              <i class='bx bx-chevron-right'></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

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
          <?php foreach($totalRevenue as $revenue): ?>
          <tr>
            <th scope="row"><?= Format::sanitize($revenue["paymentMethodName"]) ?></th>
            <td><?= Format::money($revenue["amount"]) ?></td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

</main>