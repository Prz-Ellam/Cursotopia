<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->env("APP_NAME") ?></title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../client/styles/pages/instructor-course-details.css">
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css" />

  <!-- AOS -->
  <link rel="stylesheet" href="../node_modules/aos/dist/aos.css">
  <script src="../node_modules/aos/dist/aos.js"></script>
  
  <!-- SweetAlert -->
  <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">

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
              <h6><?= $this->course["createdAt"] ?></h6>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <h6><?= $this->course["description"] ?></h6>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12">
              <a href="course-edition" class="btn btn-secondary rounded-pill">Editar curso</a>
              <button type="button" 
                class="btn btn-danger rounded-pill btn-delete-course">Deshabilitar</button>
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
                  <span>Fecha de inscripción: <?= date_format(date_create($enrollment["createdAt"]), 'd M Y') ?></span>
                </p>
                <p class="card-text mb-0">
                  <i class="bx bx-money"></i>
                  <span>Precio pagado: $<?= $enrollment["amount"] ?> MXN</span>
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
      <ul class="pagination">
        <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#"><i
              class='bx bx-chevron-left'></i></a></li>
        <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#">1</a></li>
        <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#">2</a></li>
        <li class="page-item"><a class="page-link border-0 bg-light shadow-none" href="#">3</a></li>
        <li class="page-item"><a class="page-link border-0 bg-light shadow-none" style="z-index: 0;" href="#"><i
              class='bx bx-chevron-right'></i></a></li>
      </ul>
    </div>

  </section>

  <!-- Ingresos -->
  <div class="container mb-4">
    <div class="row pt-4 pb-3">
      <div class="col-lg-12">
        <h3 class="ms-5 mb-3">Total de ingresos</h3>
        <h4 class="ms-5">$5,000.00</h4>
      </div>
    </div>
  </div>

  <?= $this->render("partials/footer") ?>
</body>
</html>