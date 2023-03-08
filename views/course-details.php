<?php ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cursotopia</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/812dd4b211.js" crossorigin="anonymous"></script>
  
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <link rel="stylesheet" href="../dist/assets/course-details.css">

  <script defer type="module" src="../dist/javascript/course-details.js"></script>
</head>
<body>
  <?= $this->render("partials/navbar") ?>

  <!-- Main -->
  <main class="my-5 container">
    <section class="row">
      <div class="col-lg-8 col-12">
        <div class="mb-4">
          <h2 class="fw-bold">Aprende a programar en Python</h2>
          <p>Creado por: <a href="instructor-profile">Nate Gentile</a></p>
        </div>
        <div class="ratio ratio-16x9 mb-4">
          <img src="https://import.cdn.thinkific.com/220744/courses/557614/hr1BWk5LTF2jiAziFPH0_aprende-a-programar-de-cero-con-python-min.jpg" alt="Curso"
            class="img-cover">
        </div>

        <h2 class="fw-bold">Descripción</h2>
        <p class="justify-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus rerum voluptatibus
          molestias nulla blanditiis, praesentium aut voluptatum nihil similique doloremque in beatae laborum id
          molestiae dolorum perferendis autem eveniet ipsum.</p>

      </div>
      <div class="rounded-3 bg-primary col-lg-4 col-12 p-4 pt-5">
        <h3 class="text-center text-white">$1,000.00 MXN</h3>
        <!-- Sin comprar -->
        
        <a href="payment-method" class="btn btn-secondary w-100">Comprar este curso</a>
        

        <!-- Gratis -->
        <!--         
        <a href="course-visor" class="btn btn-secondary w-100">Conseguir este curso</a>
        -->

        <!-- Comprado -->
        <!--
          <a href="course-visor" class="btn btn-secondary w-100">Reanudar el curso</a>
        -->
        <hr>

        <div class="mb-4">
          <span class="fw-bold rating-star">4.3</span>
          <i class="h6 bx bxs-star rating-star"></i>
          <i class="h6 bx bxs-star rating-star"></i>
          <i class="h6 bx bxs-star rating-star"></i>
          <i class="h6 bx bxs-star rating-star"></i>
          <i class="h6 bx bxs-star-half rating-star"></i>
          <a href="#" class="ms-1 text-white">4 reseñas</a>
        </div>

        <p class="text-white mb-0"><i class="h6 bx bx-time"></i> 9 horas de contenido</p>
        <p class="text-white mb-0"><i class="h6 bx bx-layer"></i> 5 níveles</p>
        <p class="text-white mb-0"><i class="h6 bx bx-group"></i> 226 estudiantes</p>
        <p class="text-white mb-0">Fecha de creación: 24 jun 2020</p>
        <p class="text-white mb-0">Última actualización: 15 sep 2022</p>

        <h3 class="mt-4 text-white text-center">Categorías</h3>
        <a
          href="search"
          class="badge bg-dark p-2 text-white rounded-pill text-decoration-none mb-3"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          data-bs-title="Basico de programación"
        >Programación</a>
        <a
          href="search"
          class="badge bg-dark p-2 text-white rounded-pill text-decoration-none mb-3"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          data-bs-title="Basico de programación"
        >Python</a>
        <a
          href="search"
          class="badge bg-dark p-2 text-white rounded-pill text-decoration-none mb-3"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          data-bs-title="Basico de programación"
        >Estructuras de datos</a>
      </div>
    </section>


    <section class="container my-5">
      <h2 class="fw-bold text-center">Contenido del curso</h2>

      <div class="border-0 card">
        <div role="button" class="rounded-top bg-light card-header" data-bs-toggle="collapse"
          data-bs-target="#collapseExample1">
          <i class='bx bx-chevron-down'></i> Introducción
        </div>
        <div class="collapse" id="collapseExample1">
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video'></i> Introducción al curso
              </span>
              <span>
                04:34
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video'></i> Sobre Java
              </span>
              <span>
                04:34
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video'></i> Sobre POO
              </span>
              <span>
                04:34
              </span>
            </li>
          </ul>
        </div>
      </div>
      <div class="card border-0">
        <div role="button" class="rounded-0 bg-light dropdown-menu-start card-header" data-bs-toggle="collapse"
          data-bs-target="#collapseExample2">
          <i class='bx bx-chevron-down'></i> Conociendo Java
        </div>
        <div class="collapse" id="collapseExample2">
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video'></i> Introducción
              </span>
              <span>
                04:34
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video'></i> Tipos, literales y variables en Java
              </span>
              <span>
                04:34
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video'></i> Estructura de decisión y petición
              </span>
              <span>
                04:34
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video'></i> Funciones
              </span>
              <span>
                04:34
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video'></i> Arrays
              </span>
              <span>
                04:34
              </span>
            </li>
          </ul>
        </div>
      </div>
      <div class="card border-0">
        <div role="button" class="rounded-0 bg-light dropdown-menu-start card-header" data-bs-toggle="collapse"
          data-bs-target="#collapseExample3">
          <i class='bx bx-chevron-down'></i> Programación Orientada a Objetos
        </div>
        <div class="collapse" id="collapseExample3">
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video'></i> Abstracción
              </span>
              <span>
                04:34
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video'></i> Encapsulamiento
              </span>
              <span>
                04:34
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video'></i> Herencia
              </span>
              <span>
                04:34
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>
                <i class='bx bxs-video align-middle'></i>
                <span class="align-middle">Polimorfismo</span>
              </span>
              <span>
                04:34
              </span>
            </li>
          </ul>
        </div>
      </div>

    </section>
    <section class="container my-2">
      <form class="p-3" id="create-review-form">
        <div class="pt-4">
          <h2 class="fw-bold text-center">Comentarios</h2>
        </div>
        <hr>
        <div>
          <label>Calificación: </label>
          <div class="rating d-inline">
            <i class="bx bx-star rate-star rating-star" star="1"></i>
            <i class="bx bx-star rate-star rating-star" star="2"></i>
            <i class="bx bx-star rate-star rating-star" star="3"></i>
            <i class="bx bx-star rate-star rating-star" star="4"></i>
            <i class="bx bx-star rate-star rating-star" star="5"></i>
          </div>
        </div>
        <input type="hidden" name="rate" id="rate" class="form-control" value="">
        <div class="mt-3 mb-3">
          <textarea class="bg-light form-control rounded-1 border-0 shadow-none" name="message" id="message-box" rows="5"
          placeholder="Escribe un comentario"></textarea>
        </div>
        <button type="submit" class="btn btn-primary rounded-5 border-0 shadow-none mb-4"
          id="send-message">Publicar</button>
        <div id="comment-section"></div>
      </form>
    </section>


    <section class="container">
      <h4 class="mb-4">Comentarios recientes</h4>
      <div id="review-section">

        <div class="card-body p-4">
          <div class="d-flex flex-start">
            <img class="rounded-circle me-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(23).webp"
              alt="avatar" width="60" height="60" />
            <div>
              <div class="d-flex justify-content-between">
                <div>
                  <a class="fw-bold mb-1">Maggie Marsh</a>
                  <div class="d-flex align-items-center mb-1 gap-2">
                    <small class="mb-0">07 mar 2021 8:21</small>
                    <span>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                    </span>
                  </div>
                </div>
                <a href="#"
                  class="nav-link"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Eliminar</a></li>
                </ul>
              </div>
              <p class="mb-0">
                Lorem Ipsum is simply dummy text of the printing and typesetting
                industry. Lorem Ipsum has been the industry's standard dummy text ever
                since the 1500s, when an unknown printer took a galley of type and
                scrambled it.
              </p>
            </div>
          </div>
        </div>

        <hr class="my-0">

        <div class="card-body p-4">
          <div class="d-flex flex-start">
            <img class="rounded-circle me-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(26).webp"
              alt="avatar" width="60" height="60" />
            <div>
              <a class="fw-bold mb-1">Lara Stewart</a>
              <div class="d-flex align-items-center mb-1 gap-2">
                <small class="mb-0">15 mar 2021 2:21</small>
                <span>
                  <i class="bx bxs-star rating-star"></i>
                  <i class="bx bxs-star rating-star"></i>
                  <i class="bx bxs-star rating-star"></i>
                  <i class="bx bxs-star rating-star"></i>
                  <i class="bx bxs-star rating-star"></i>
                </span>
              </div>
              <p class="mb-0">
                Contrary to popular belief, Lorem Ipsum is not simply random text. It
                has roots in a piece of classical Latin literature from 45 BC, making it
                over 2000 years old. Richard McClintock, a Latin professor at
                Hampden-Sydney College in Virginia, looked up one of the more obscure
                Latin words, consectetur, from a Lorem Ipsum passage, and going through
                the cites.
              </p>
            </div>
          </div>
        </div>

        <hr class="my-0">

        <div class="card-body p-4">
          <div class="d-flex flex-start">
            <img class="rounded-circle me-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(33).webp"
              alt="avatar" width="60" height="60" />
            <div>
              <a class="fw-bold mb-1">Alexa Bennett</a>
              <div class="d-flex align-items-center mb-1 gap-2">
                <small class="mb-0">24 mar 2021 13:43</small>
                <span>
                  <i class="bx bxs-star rating-star"></i>
                  <i class="bx bxs-star rating-star"></i>
                  <i class="bx bxs-star rating-star"></i>
                  <i class="bx bxs-star rating-star"></i>
                  <i class="bx bxs-star rating-star"></i>
                </span>
              </div>
              <p class="mb-0">
                There are many variations of passages of Lorem Ipsum available, but the
                majority have suffered alteration in some form, by injected humour, or
                randomised words which don't look even slightly believable. If you are
                going to use a passage of Lorem Ipsum, you need to be sure.
              </p>
            </div>
          </div>
        </div>

        <hr class="my-0">

        <div class="card-body p-4">
          <div class="d-flex flex-start">
            <img class="rounded-circle me-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(24).webp"
              alt="avatar" width="60" height="60" />
            <div>
              <a class="fw-bold mb-1">Betty Walker</a>
              <div class="d-flex align-items-center mb-1 gap-2">
                <small class="mb-0">30 mar 2021 00:34</small>
                <span>
                  <i class="bx bx-star rating-star"></i>
                  <i class="bx bx-star rating-star"></i>
                  <i class="bx bx-star rating-star"></i>
                  <i class="bx bx-star rating-star"></i>
                  <i class="bx bx-star rating-star"></i>
                </span>
              </div>
              <p class="mb-0">
                It uses a dictionary of over 200 Latin words, combined with a handful of
                model sentence structures, to generate Lorem Ipsum which looks
                reasonable. The generated Lorem Ipsum is therefore always free from
                repetition, injected humour, or non-characteristic words etc.
              </p>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-center">
          <button class="btn btn-primary w-100 rounded-pill">Mostrar más comentarios</button>
        </div>
      </div>
    </section>



  </main>

  <?= $this->render("partials/footer") ?>
</body>
</html>