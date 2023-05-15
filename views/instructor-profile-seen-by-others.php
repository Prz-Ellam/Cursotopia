<?php

use Cursotopia\Helpers\Format;
use Cursotopia\Repositories\CourseRepository;

$id = $_GET["id"] ?? -1;

$page = $_GET["page"] ?? 1;

$perPageElement = 6;
$start = ($page - 1) * $perPageElement;

$limit = $perPageElement;
$offset = $start;

$courseRepository = new CourseRepository();
$total = $courseRepository->instructorCoursesSeenByOtherTotal($id)["total"];

$totalPages = ceil($total / $perPageElement);
$totalButtons = $totalPages > 5 ? 5 : $totalPages;

$courses = $courseRepository->instructorCoursesSeenByOtherReport($id, $limit, $offset);
?>
<main>
  <?= $this->link("styles/pages/instructor-profile-seen-by-others.css") ?>
  <!-- Hero -->
  <div class="Hero">
    <div class="container-fluid bg-light shadow-sm">
      <div class="row p-4">
        <div class="col-xl-2 col-md-4 col-sm-5 col-xs-12">
        <img src="api/v1/images/<?= $this->user["profilePicture"] ?>" class="img-hero" width="180" height="180" alt="Foto de perfil">
        </div>
        <div class="col-xl-10 col-md-8 col-sm-7 col-xs-12 m-auto">
          <div class="container text-xs-center">
            <div class="row">
              <div class="col-12">
                <h4><?= $this->user["name"] . " " . $this->user["lastName"] ?></h4>
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
            <!-- Mandar mensaje solo sale para alumnos de ese instructor -->
            <!--div class="row mt-3">
              <?php if (isset($_SESSION["id"])): ?>
              <div class="col-12">
                <a href="chat" class="btn btn-secondary rounded-pill">Mandar mensaje</a>
              </div>
              <?php endif ?>
            </div-->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contenido -->
  <div class="container">
    <div class="row mt-4">
      <div class="col-12">
        <h3 class="fw-bold">Cursos impartidos</h3>
      </div>
    </div>

    <div class="container mt-4">
      <?php foreach($courses as $course): ?>
      <div data-aos="fade-up">
        <div class="card mb-4 bg-light border-0">
          <div class="row g-0">
            <div class="col-md-4">
              <div class="ratio ratio-16x9 h-100">
                <img src="/api/v1/images/<?= $course["imageId"] ?>" 
                  class=" img-cover img-fluid rounded-start" alt="...">
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h4 class="card-title"><?= $course["title"] ?></h4>
                <hr>
                <p class="card-text mb-0 d-flex align-items-center">
                  <i class='bx bxs-group me-1'></i>
                  <span>Cantidad de alumnos: <?= $course["enrollments"] ?></span>
                </p>
                <p class="card-text mb-0 d-flex align-items-center">
                  <i class='bx bxs-like me-1'></i>
                  <span>Puntuación:
                  <?php if($course["rate"] == 0): ?>
                    No hay reseñas
                  <?php else: ?>
                    <i class="bx <?= $course["rate"] >= 1 ? "bxs-star": ($course["rate"] >= 0.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
                    <i class="bx <?= $course["rate"] >= 2 ? "bxs-star": ($course["rate"] >= 1.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
                    <i class="bx <?= $course["rate"] >= 3 ? "bxs-star": ($course["rate"] >= 2.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
                    <i class="bx <?= $course["rate"] >= 4 ? "bxs-star": ($course["rate"] >= 3.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
                    <i class="bx <?= $course["rate"] >= 5 ? "bxs-star": ($course["rate"] >= 4.5 ? 'bxs-star-half' : 'bx-star') ?> rating-star"></i>
                  <?php endif ?>
                  </span>
                </p>
                <p class="card-text d-flex align-items-center">
                  <i class='bx bx-money me-1'></i>
                  <span>Precio: <?= Format::money($course["price"]) ?></span> 
                </p>
                <a href="/course-details?id=<?= $course["id"] ?>" 
                class="btn btn-secondary rounded-pill">
                  Ver detalles del curso
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
  </div>

</main>