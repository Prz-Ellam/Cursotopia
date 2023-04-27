<?php

use Cursotopia\Helpers\Format;
use Cursotopia\Models\CourseModel;
use Cursotopia\Repositories\CategoryRepository;

$categoryId = $_GET["category"] ?? null;
$from = $_GET["from"] ?? null;
$to = $_GET["to"] ?? null;
$complete = $_GET["complete"] ?? 0;
$active = $_GET["active"] ?? 0;
$page = $_GET["page"] ?? 1;

$perPageElement = 12;
$start = ($page - 1) * $perPageElement;

$limit = $perPageElement;
$offset = $start;

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

$total = CourseModel::kardexReportTotal(
  $this->session("id"),
  $categoryId,
  $from,
  $to,
  $complete,
  $active
);

$totalPages = ceil($total / $perPageElement);
$totalButtons = $totalPages > 5 ? 5 : $totalPages;

$courses = CourseModel::kardexReport(
  $this->session("id"),
  $categoryId,
  $from,
  $to,
  $complete,
  $active,
  $limit,
  $offset
);



$categoryRepository = new CategoryRepository();
$categories = $categoryRepository->findAll();
?>
<main>
  <!-- Hero -->
  <div class="Hero">
    <div class="container-fluid bg-light shadow-sm">
      <div class="row p-4">
        <div class="col-xl-2 col-md-4 col-sm-5 col-xs-12 ml-4">
          <img src="api/v1/images/<?= $this->user["profilePicture"] ?>" class="img-hero" width="180" height="180" alt="Foto de perfil">
        </div>
        <div class="col-xl-10 col-md-8 col-sm-7 col-xs-12 m-auto ">
          <div class="container text-xs-center">
            <div class="row">
              <div class="col-12">
                <h3 class="fw-bold"><?= $this->user["name"] ?></h3>
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
                <a href="profile-edition" class="btn btn-secondary border-0 rounded-5 shadow-none">
                  Editar perfil
                </a>
                <a href="password-edition" class="btn btn-secondary border-0 rounded-5 shadow-none">
                  Cambiar contraseña
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contenido -->
  <div class="container">
    <h3 class="fw-bold mt-4">Kardex</h3>
    <h6 class="mt-3">Filtros</h6>

    <form class="row" action="" method="GET">
      <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
      <div class="d-flex col-xs-12 col-sm-6 col-md-6 col-lg-3 select-date">
        <label for="" class="form-label me-3">Fecha inicial:</label>
        <input type="date" name="from" class="form-control w-50">
      </div>
      <div class="d-flex col-xs-12 col-sm-6 col-md-6 col-lg-3 select-date">
        <label for="" class="form-label me-3">Fecha final:</label>
        <input type="date" name="to" class="form-control w-50">
      </div>
      <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2 select-box">
        <label for="" class="form-label">Categoria:</label>
      </div>
      <div class="col-lg-4 col-md-10 col-sm-10 col-xs-10 select-box">
        <select class="form-select" name="category">
          <option selected value="">Categorias</option>
          <?php foreach ($categories as $category) : ?>
            <option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="col-lg-3 col-xxl-2 col-md-4 col-sm-5 mt-3 col-xs-6">
        <div class="form-check form-check-inline">
          <input class="form-check-input" name="complete" type="checkbox" id="inlineCheckbox1" value="1">
          <label class="form-check-label" for="inlineCheckbox1">Solo completados</label>
        </div>
      </div>
      <div class="col-lg-2 col-sm-4 mt-3 col-xs-6">
        <div class="form-check form-check-inline">
          <input class="form-check-input" name="active" type="checkbox" id="inlineCheckbox2" value="1">
          <label class="form-check-label" for="inlineCheckbox2">Solo activos</label>
        </div>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary rounded-pill">Buscar</button>
      </div>
    </form>


    <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="kardex-tab" data-bs-toggle="tab" data-bs-target="#kardex-tab-pane" type="button" role="tab" aria-controls="kardex-tab-pane" aria-selected="true">Kardex</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-tab-pane" type="button" role="tab" aria-controls="list-tab-pane" aria-selected="false">Lista de cursos</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="kardex-tab-pane" role="tabpanel" aria-labelledby="kardex-tab" tabindex="0">

        <div class="row pt-3" id="no-more-tables">
          <table class="table w-100">
            <thead>
              <tr>
                <th>Curso</th>
                <th>Progreso</th>
                <th>Fecha de inscripción</th>
                <th>Último ingreso</th>
                <th>Terminado el</th>
                <th>Estado</th>
                <th>Certificado</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($courses as $course) : ?>
                <tr>
                  <td data-title="Curso">
                    <a href="course-details?id=<?= $course["id"] ?>"
                      class="text-decoration-none">
                      <?= $course["title"] ?>
                    </a>
                  </td>
                  <td data-title="Progreso"><?= $course["progress"] ?>%</td>
                  <td data-title="Fecha de inscripción"><?= Format::date($course["enrollDate"]) ?></td>
                  <td data-title="Último ingreso"><?= Format::date($course["lastTimeChecked"]) ?></td>
                  <td data-title="Terminado el"><?= Format::date($course["finishDate"]) ?></td>
                  <td data-title="Estado"><?= $course["status"] ?></td>
                  <td data-title="Certificado">
                    <?php if ($course["isFinished"]): ?>
                    <a href="certificate?course=<?= $course["id"] ?>"
                      class="text-decoration-none">
                      Ver más
                    </a>
                    <?php else: ?>
                    <a style="visibility:hidden">.</a>
                    <?php endif ?>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

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
      <div class="tab-pane fade" id="list-tab-pane" role="tabpanel" aria-labelledby="list-tab" tabindex="0">

        <div class="container mt-4">

          <div data-aos="fade-up">
            <div class="card mb-4 bg-light border-0">
              <div class="row g-0">
                <div class="col-md-4">
                  <div class="ratio ratio-16x9 h-100">
                    <img src="https://import.cdn.thinkific.com/220744/courses/1948561/HVgczjlDQjK5CIXpb57p_desarrollo-web-con-html-css-min.png" class="img-cover img-fluid rounded-start" alt="...">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h4 class="card-title">Crea páginas web con HTML y CSS</h4>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-calendar me-1'></i>Fecha de inscripción: 22 sep 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bx-calendar-exclamation'></i>Último ingreso: 13 oct 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-calendar-check me-1'></i>Terminado el: 13 oct 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-graduation me-1'></i>Estado: Finalizado</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bx-chart me-1'></i> Progreso: 100%</p>
                    <div class="progress mb-3">
                      <div class="progress-bar w-100 bg-primary" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                    <a href="course-visor" class="btn btn-secondary rounded-5 border-0 shadow-none">Continuar curso</a>
                    <a href="course-details" class="btn btn-secondary rounded-5 border-0 shadow-none">Ver detalles del curso</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div data-aos="fade-up">
            <div class="card mb-4 bg-light border-0">
              <div class="row g-0">
                <div class="col-md-4">
                  <div class="ratio ratio-16x9 h-100">
                    <img src="https://import.cdn.thinkific.com/220744/courses/557614/hr1BWk5LTF2jiAziFPH0_aprende-a-programar-de-cero-con-python-min.jpg" class="img-cover img-fluid rounded-start" alt="...">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h4 class="card-title">Introducción a la Programación</h4>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-calendar me-1'></i>Fecha de inscripción: 22 sep 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bx-calendar-exclamation'></i>Último ingreso: 13 oct 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-calendar-check me-1'></i>Terminado el: 13 oct 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-graduation me-1'></i>Estado: Finalizado</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bx-chart me-1'></i> Progreso: 100%</p>
                    <div class="progress mb-3">
                      <div class="progress-bar w-100 bg-primary" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                    <a href="course-visor" class="btn btn-secondary rounded-5 border-0 shadow-none">Continuar curso</a>
                    <a href="course-details" class="btn btn-secondary rounded-5 border-0 shadow-none">Ver detalles del curso</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div data-aos="fade-up">
            <div class="card mb-4 bg-light border-0">
              <div class="row g-0">
                <div class="col-md-4">
                  <div class="ratio ratio-16x9 h-100">
                    <img src="https://import.cdn.thinkific.com/220744/courses/881985/h20jls3OSdiMYPpYXpJC_Tu%20propio%20entorno%20de%20escritorio%20Arch%20linux-min.jpg" class="img-cover img-fluid rounded-start" alt="...">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h4 class="card-title">Crea tu propio entorno de desarrollo con Linux</h4>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-calendar me-1'></i>Fecha de inscripción: 22 sep 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bx-calendar-exclamation'></i>Último ingreso: 13 oct 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-calendar-check me-1'></i>Terminado el: 13 oct 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-graduation me-1'></i>Estado: Finalizado</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bx-chart me-1'></i> Progreso: 100%</p>
                    <div class="progress mb-3">
                      <div class="progress-bar w-100 bg-primary" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                    <a href="course-visor" class="btn btn-secondary rounded-5 border-0 shadow-none">Continuar curso</a>
                    <a href="course-details" class="btn btn-secondary rounded-5 border-0 shadow-none">Ver detalles del curso</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div data-aos="fade-up">
            <div class="card mb-4 bg-light border-0">
              <div class="row g-0">
                <div class="col-md-4">
                  <div class="ratio ratio-16x9 h-100">
                    <img src="https://pikuma.com/images/courses/nes.jpg" class="img-cover img-fluid rounded-start" alt="...">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h4 class="card-title">Programación en NES</h4>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-calendar me-1'></i>Fecha de inscripción: 22 sep 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bx-calendar-exclamation'></i>Último ingreso: 13 oct 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-calendar-check me-1'></i>Terminado el: 13 oct 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-graduation me-1'></i>Estado: Finalizado</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bx-chart me-1'></i> Progreso: 100%</p>
                    <div class="progress mb-3">
                      <div class="progress-bar w-100 bg-primary" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                    <a href="course-visor" class="btn btn-secondary rounded-5 border-0 shadow-none">Continuar curso</a>
                    <a href="course-details" class="btn btn-secondary rounded-5 border-0 shadow-none">Ver detalles del curso</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div data-aos="fade-up">
            <div class="card mb-4 bg-light border-0">
              <div class="row g-0">
                <div class="col-md-4">
                  <div class="ratio ratio-16x9 h-100">
                    <img src="https://pikuma.com/images/courses/2dgameengine.jpg" class="img-cover img-fluid rounded-start" alt="...">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h4 class="card-title">Desarrollo de videojuegos en C++</h4>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-calendar me-1'></i>Fecha de inscripción: 22 sep 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bx-calendar-exclamation'></i>Último ingreso: 13 oct 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-calendar-check me-1'></i>Terminado el: 13 oct 2022</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-graduation me-1'></i>Estado: Finalizado</p>
                    <p class="card-text mb-0 d-flex align-items-center"><i class='bx bx-chart me-1'></i> Progreso: 100%</p>
                    <div class="progress mb-3">
                      <div class="progress-bar w-100 bg-primary" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                    <a href="course-visor" class="btn btn-secondary rounded-5 border-0 shadow-none">Continuar curso</a>
                    <a href="course-details" class="btn btn-secondary rounded-5 border-0 shadow-none">Ver detalles del curso</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

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

      </div>
    </div>



    <div class="row mt-4 me-5">
      <div class="col-lg-12 col-md-6">

      </div>

    </div>
  </div>

  <!-- Cambiar photo -->
  <div class="modal fade" id="changePhoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Cambiar foto</h4>
        </div>
        <div class="modal-body">

          <div class="wrapper">
            <div class="box">
              <div class="input-bx">
                <form action="">
                  <input type="file" id="Upload" hidden>
                  <label for="Upload" class="uploadlabel">
                    <span class=""><i class='bx bxs-cloud-upload'></i></span>
                    <p>Oprime para añadir</p>
                  </label>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="close-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="save-btn" type="button" class="btn btn-secondary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</main>