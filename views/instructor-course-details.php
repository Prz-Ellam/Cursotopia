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

  <?= $this->link("styles/pages/instructor-course-details.css") ?>
  <?= $this->script("javascript/instructor-course-details.js")  ?>
</head>
<body>
  <!-- Navbar -->
  <?= $this->render("partials/navbar") ?>

  <div class="container-fluid bg-light shadow-sm">
    <div class="row p-4">
      <div class="text-center col-xl-2 col-md-4 col-sm-5 col-xs-12">
        <img
          src="/api/v1/images/<?= $this->course["imageId"] ?>"
          width="180"
          class="img-fluid mb-4" 
          alt="Curso"
        >   
      </div>
      <div class="col-xl-10 col-md-8 col-sm-7 col-xs-12 m-auto">
        <div class="container text-xs-center">
          <div class="row">
            <div class="col-12">
              <h3 class="fw-bold"><?= $this->course["title"] ?></h3>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <h6><?= Format::date($this->course["createdAt"]) ?></h6>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <h6><?= $this->course["description"] ?></h6>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12">
              <?php if ($this->course["active"]): ?>
              <a href="/course-edition?id=<?= $this->course["id"] ?>" 
                class="btn btn-secondary rounded-pill">
                Editar curso
              </a>
              <button type="button" 
                class="btn btn-danger rounded-pill btn-delete-course">
                Deshabilitar
              </button>
              <?php else: ?>
                Eliminado
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Contenido -->
  <!-- Cards -->

  <div class="container">
    <h2 class="fw-bold mt-4">Alumnos</h2>
  </div>

  <section class="container" id="cards">
  <?php $total = 0 ?>
  <?php foreach($this->enrollments as $enrollment): ?>
    <div data-aos="fade-up">
      <a 
        href="/profile?id=<?= $enrollment["userId"] ?>"
        class="card mt-3 mb-4 bg-light border-0 text-decoration-none text-dark" 
        role="button">
        <div class="row g-0">
          <div class="col-sm-4 col-md-2 col-xs-12 align-items-center d-flex">
            <img
              src="/api/v1/images/<?= $enrollment["profilePicture"] ?>"
              width="150" height="150"
              style="width: 150px; height: 150px"
              class="img-cover img-fluid rounded-pill p-3"
              alt="Foto de perfil">
          </div>
  
          <div class="col-sm-8 col-md-10 col-xs-12">
            <div class="card-body">
              <h4 class="card-title text-xs-center">
                <?= $enrollment["username"] ?>
              </h4>
              <hr class="my-1">
                <p class="card-text mb-0">
                  <i class="bx bx-cube"></i>
                  <span>Fecha de inscripción: <?= Format::date($enrollment["createdAt"]) ?></span>
                </p>
                <p class="card-text mb-0">
                  <i class="bx bx-money"></i>
                  <span>Precio pagado: <?= Format::money($enrollment["amount"]) ?></span>
                  <?php $total += $enrollment["amount"] ?>
                </p>
                <p class="card-text mb-0">
                  <i class="bx bxs-credit-card"></i>
                  <span>Forma de pago: <?= $enrollment["paymentMethodName"] ?></span>
                </p>
                <p class="card-text mb-0">
                  <i class="bx bx-chart"></i>
                  <span>Progreso: <?= $enrollment["percentageComplete"] ?>%</span>
                </p>
                <div class="progress">
                  <div
                    class="progress-bar bg-primary"
                    role="progressbar"
                    aria-label="Basic example"
                    aria-valuenow="<?= $enrollment["percentageComplete"] ?>"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    style="width: <?= $enrollment["percentageComplete"] ?>%"
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
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

  </section>

  <!-- Ingresos -->
  <div class="container mb-4">
    <div class="row pt-4 pb-3">
      <div class="col-lg-12">
        <h3 class="ms-5 mb-3">Total de ingresos</h3>
        <h4 class="ms-5"><?= Format::money($total) ?></h4>
      </div>
    </div>
  </div>

  <?= $this->render("partials/footer") ?>
</body>
</html>