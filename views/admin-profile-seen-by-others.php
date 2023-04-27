<?php

use Cursotopia\Helpers\Format;
?>
<main>
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
            <div class="row mt-3">
              <?php if (isset($_SESSION["id"])): ?>
              <div class="col-12">
                <a href="chat" class="btn btn-secondary rounded-pill">Mandar mensaje</a>
              </div>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contenido -->
  <div class="container">
    <div class="row mt-4">
      <div class="col-12">
        <h3 class="fw-bold">Cursos aprobados</h3>
      </div>
    </div>

    <div class="container mt-4">
      <div data-aos="fade-up">
        <div class="card mb-4 bg-light border-0">
          <div class="row g-0">
            <div class="col-md-4">
              <div class="ratio ratio-16x9 h-100">
                <img src="https://import.cdn.thinkific.com/220744/courses/1948561/HVgczjlDQjK5CIXpb57p_desarrollo-web-con-html-css-min.png" class=" img-cover img-fluid rounded-start" alt="...">
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h4 class="card-title">Crea páginas web con HTML y CSS</h4>
                <hr>
                <p class="card-text mb-0 d-flex align-items-center">
                  <i class='bx bxs-group me-1'></i>Cantidad de alumnos: 6
                </p>
                <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-like me-1'></i>Puntuación:
                  <span>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                  </span>
                </p>
                <p class="card-text d-flex align-items-center">
                  <i class='bx bx-money me-1'></i>Precio: $200.00 MXN
                </p>
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
                <img src="https://i.ytimg.com/vi/45MIykWJ-C4/maxresdefault.jpg" class=" img-cover img-fluid rounded-start" alt="...">
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h4 class="card-title">Aprende todo sobre OpenGL</h4>
                <hr>
                <p class="card-text mb-0 d-flex align-items-center">
                  <i class='bx bxs-group me-1'></i>Cantidad de alumnos: 6
                </p>
                <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-like me-1'></i>Puntuación:
                  <span>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                  </span>
                </p>
                <p class="card-text d-flex align-items-center">
                  <i class='bx bx-money me-1'></i>Precio: $200.00 MXN
                </p>
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
                <img src="https://import.cdn.thinkific.com/220744/courses/881985/h20jls3OSdiMYPpYXpJC_Tu%20propio%20entorno%20de%20escritorio%20Arch%20linux-min.jpg" class=" img-cover img-fluid rounded-start" alt="...">
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h4 class="card-title">Crea tu propio entorno de desarrollo con Linux</h4>
                <hr>
                <p class="card-text mb-0 d-flex align-items-center">
                  <i class='bx bxs-group me-1'></i>Cantidad de alumnos: 6
                </p>
                <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-like me-1'></i>Puntuación:
                  <span>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                  </span>
                </p>
                <p class="card-text d-flex align-items-center">
                  <i class='bx bx-money me-1'></i>Precio: $200.00 MXN
                </p>
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
                <img src="https://import.cdn.thinkific.com/220744/courses/557614/hr1BWk5LTF2jiAziFPH0_aprende-a-programar-de-cero-con-python-min.jpg" class=" img-cover img-fluid rounded-start" alt="...">
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h4 class="card-title">Introducción a la Programación</h4>
                <hr>
                <p class="card-text mb-0 d-flex align-items-center">
                  <i class='bx bxs-group me-1'></i>Cantidad de alumnos: 6
                </p>
                <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-like me-1'></i>Puntuación:
                  <span>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                  </span>
                </p>
                <p class="card-text d-flex align-items-center">
                  <i class='bx bx-money me-1'></i>Precio: $200.00 MXN
                </p>
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
                <img src="https://pikuma.com/images/courses/nes.jpg" class=" img-cover img-fluid rounded-start" alt="...">
              </div>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h4 class="card-title">Programación en NES</h4>
                <hr>
                <p class="card-text mb-0 d-flex align-items-center">
                  <i class='bx bxs-group me-1'></i>Cantidad de alumnos: 6
                </p>
                <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-like me-1'></i>Puntuación:
                  <span>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                    <i class="bx bxs-star rating-star"></i>
                  </span>
                </p>
                <p class="card-text d-flex align-items-center">
                  <i class='bx bx-money me-1'></i>Precio: $200.00 MXN
                </p>
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

</main>