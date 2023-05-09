<?php

use Cursotopia\Helpers\Format;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\CourseModel;
use Cursotopia\Repositories\CategoryRepository;

$categoryId = $_GET["category"] ?? null;
$startDate = $_GET["start_date"] ?? null;
$endDate = $_GET["end_date"] ?? null;
$complete = $_GET["complete"] ?? 0;
$active = $_GET["active"] ?? 0;
$page = $_GET["page"] ?? 1;

$perPageElement = 12;
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

$total = CourseModel::kardexReportTotal(
  $this->session("id"),
  $categoryId,
  $startDate,
  $endDate,
  $complete,
  $active
);

$totalPages = ceil($total / $perPageElement);
$totalButtons = $totalPages > 5 ? 5 : $totalPages;

$courses = CourseModel::kardexReport(
  $this->session("id"),
  $categoryId,
  $startDate,
  $endDate,
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

      <div class="col-lg-3 col-xxl-2 col-md-4 col-sm-5 mt-3 col-xs-6">
        <div class="form-check form-check-inline">
          <input class="form-check-input" name="complete" type="checkbox" 
            id="inlineCheckbox1" value="1" <?= $_GET["complete"] ?? "" ? "checked": "" ?>>
          <label class="form-check-label" for="inlineCheckbox1">Solo completados</label>
        </div>
      </div>
      <div class="col-lg-2 col-sm-4 mt-3 col-xs-6">
        <div class="form-check form-check-inline">
          <input class="form-check-input" name="active" type="checkbox" id="inlineCheckbox2" 
          value="1" <?= $_GET["active"] ?? "" ? "checked": "" ?>>
          <label class="form-check-label" for="inlineCheckbox2">Solo activos</label>
        </div>
      </div>
      <div class="d-grid mt-2">
        <button type="submit" class="btn btn-primary rounded-pill">Buscar</button>
      </div>
    </form>


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
                  <td data-title="Fecha de inscripción">
                    <?= Format::date($course["enrollDate"]) ?>
                  </td>
                  <td data-title="Último ingreso">
                    <?= Format::date($course["lastTimeChecked"]) ?>
                  </td>
                  <td data-title="Terminado el">
                    <?= Format::date($course["finishDate"]) ?>
                  </td>
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
              <i class="bx bx-chevron-right"></i>
            </a>
          </li>
        </ul>
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