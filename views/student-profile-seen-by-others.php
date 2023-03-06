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
  
  <!-- AOS -->
  <link rel="stylesheet" href="../node_modules/aos/dist/aos.css">
  <script src="../node_modules/aos/dist/aos.js"></script>
  
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../client/styles/pages/student-profile-seen-by-others.css">
  <link rel="stylesheet" href="../dist/assets/instructor-profile-seen-by-others.css">
  <script defer src="../dist/javascript/instructor-profile.js"></script>
</head>
<body>
  <!-- Navbar de estudiante -->
  <nav class="sticky-top navbar navbar-expand-lg bg-primary shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand text-white" href="home">
        <img src="../client/assets/images/logo.png" alt="Logo" width="34" height="34" class="d-inline-block align-text-top">
        <span class="align-middle">Cursotopia</span>
      </a>
      <button 
        class="border-0 shadow-none navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbar-content"
        aria-controls="navbar-content"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="text-white bx-sm bx bx-menu"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-content">
        <form class="col-md-auto col-lg-5 col-xl-7" role="search" action="search">
          <div class="input-group">
            <input
              class="form-control bg-white"
              type="search"
              placeholder="Buscar cursos..."
              aria-label="Search">
            <button class="btn btn-white border-0 text-dark search-btn" type="submit">
              <i class="fw-bold bx bx-search"></i>
            </button>
          </div>
        </form>
        <ul class="navbar-nav ms-auto d-lg-flex align-items-lg-center me-2">
          <li class="nav-item">
            <a href="student-profile" class="nav-link fw-bold text-light">
              Mis cursos
            </a>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link fw-bold text-light dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Categorías
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="search">Arte</a></li>
              <li><a class="dropdown-item" href="search">Música</a></li>
              <li><a class="dropdown-item" href="search">Programación</a></li>
            </ul>
          </li>    
          <li class="nav-item">
            <a class="nav-link text-light" aria-current="page" href="chat">
              <i class="bx-sm bx bxs-bell position-relative">
                <span class="badge rounded-pill badge-notification bg-danger">1</span>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <div class="nav-link dropdown">
              <button
                class="btn border-0 p-0"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <img 
                  src="../client/assets/images/perfil.png"
                  alt="mdo"
                  width="32"
                  class="rounded-circle profile-picture">
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item" href="instructor-profile">Mi perfil</a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item" href="#">Cerrar sesión</a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div>
    <!-- Hero -->
    <div class="Hero">
			<div class="container-fluid bg-light shadow-sm">
				<div class="row p-4">
					<div class="col-xl-2 col-md-4 col-sm-5 col-xs-12 ml-4">
						<img
							src="https://pbs.twimg.com/profile_images/1251100214926032896/MhdWgkD1_400x400.jpg"
							class="img-hero"
              width="180"
              alt="Foto de perfil">
					</div>
					<div class="col-xl-10 col-md-8 col-sm-7 col-xs-12 m-auto ">
						<div class="container text-xs-center">
							<div class="row">
								<div class="col-12">
									<h3 class="fw-bold">Nombre completo</h3>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<h6>Usuario</h6>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<h6>Fecha de nacimiento</h6>
								</div>
							</div>
							<!-- Solo aparece si lo está viendo el administrador -->
              <!-- <div class="row mt-3">
                        <div class="col-12">
                            <button class="btn btn-secondary">Bloquear usuario</button>
                        </div>
              </div> -->
						</div>
					</div>
				</div>
			</div>
		</div>

    <!-- Contenido -->
    <div class="container">
      <div class="row mt-4">
        <div class="col-12">
          <h3 class="fw-bold">Cursos a los que está inscrito</h3>
        </div>
      </div>

      <!-- Cards -->
      <div class="container mt-4">
        
        <div data-aos="fade-up">
          <div class="card mb-4 bg-light border-0">
            <div class="row g-0">
              <div class="col-md-4">
                <div class="ratio ratio-16x9 h-100">
                  <img src="https://import.cdn.thinkific.com/220744/courses/557614/hr1BWk5LTF2jiAziFPH0_aprende-a-programar-de-cero-con-python-min.jpg" 
                  class=" img-cover img-fluid rounded-start" alt="...">
                </div>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h4 class="card-title">Introducción a la Programación</h4>
                  <hr>
                  <p class="card-text mb-0 d-flex align-items-center"><i class="bx bxs-chalkboard me-1"></i>Instructor: Nate Gentile</p>
                  <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-like me-1'></i> Puntuación:
                    <span>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                    </span>
                  </p>
                  <p class="card-text d-flex align-items-center"><i class="bx bx-money me-1"></i>Precio: $350.00 MXN</p>
                  <a href="course-details" class="btn btn-secondary rounded-pill border-0 shadow-none">Ver detalles del curso</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="card mb-4 bg-light border-0">
            <div class="row g-0">
              <div class="col-md-4">
                <div class="ratio ratio-16x9 h-100">
                  <img src="https://import.cdn.thinkific.com/220744/courses/1652554/m8sF2qn5R7WkrFrvDAJe_Seguridad%20pc-min.jpg" 
                  class=" img-cover img-fluid rounded-start" alt="...">
                </div>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h4 class="card-title">Como protegerse en la red</h4>
                  <hr>
                  <p class="card-text mb-0 d-flex align-items-center"><i class="bx bxs-chalkboard me-1"></i>Instructor: Kike Gandia</p>
                  <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-like me-1'></i>Puntuación:
                    <span>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                    </span>
                  </p>
                  <p class="card-text d-flex align-items-center"><i class="bx bx-money me-1"></i>Precio: $350.00 MXN</p>
                  <a href="course-details" class="btn btn-secondary rounded-pill border-0 shadow-none">Ver detalles del curso</a>
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
                  <img src="https://import.cdn.thinkific.com/220744/courses/1948561/HVgczjlDQjK5CIXpb57p_desarrollo-web-con-html-css-min.png" 
                  class=" img-cover img-fluid rounded-start" alt="...">
                </div>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h4 class="card-title">Crea páginas web con HTML y CSS</h4>
                  <hr>
                  <p class="card-text mb-0 d-flex align-items-center"><i class="bx bxs-chalkboard me-1"></i>Instructor: Paco Gomez Arnal</p>
                  <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-like me-1'></i> Puntuación:
                    <span>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                    </span>
                  </p>
                  <p class="card-text d-flex align-items-center"><i class="bx bx-money me-1"></i>Precio: $350.00 MXN</p>
                  <a href="course-details" class="btn btn-secondary rounded-pill border-0 shadow-none">Ver detalles del curso</a>
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
                  <img src="https://import.cdn.thinkific.com/220744/courses/881985/h20jls3OSdiMYPpYXpJC_Tu%20propio%20entorno%20de%20escritorio%20Arch%20linux-min.jpg" 
                  class=" img-cover img-fluid rounded-start" alt="...">
                </div>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h4 class="card-title">Crea tu propio entorno de desarrollo con Linux</h4>
                  <hr>
                  <p class="card-text mb-0 d-flex align-items-center"><i class="bx bxs-chalkboard me-1"></i>Instructor: Antonio Sarosi</p>
                  <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-like me-1'></i> Puntuación:
                    <span>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                    </span>
                  </p>
                  <p class="card-text d-flex align-items-center"><i class="bx bx-money me-1"></i>Precio: $350.00 MXN</p>
                  <a href="course-details" class="btn btn-secondary rounded-pill border-0 shadow-none">Ver detalles del curso</a>
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
                  <img src="https://pikuma.com/images/courses/nes.jpg" 
                  class=" img-cover img-fluid rounded-start" alt="...">
                </div>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h4 class="card-title">Programación en NES</h4>
                  <hr>
                  <p class="card-text mb-0 d-flex align-items-center"><i class="bx bxs-chalkboard me-1"></i>Instructor: Pikuma</p>
                  <p class="card-text mb-0 d-flex align-items-center"><i class='bx bxs-like me-1'></i> Puntuación:
                    <span>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                      <i class="bx bxs-star rating-star"></i>
                    </span>
                  </p>
                  <p class="card-text d-flex align-items-center"><i class="bx bx-money me-1"></i>Precio: $350.00 MXN</p>
                  <a href="course-details" class="btn btn-secondary rounded-pill border-0 shadow-none">Ver detalles del curso</a>
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

  <!-- Footer -->
  <footer class="page-footer p-5 bg-light">
    <div class="container-fluid">
      <div class="row text-md-start text-center">
        <div class="col-md-3 mx-auto mb-3">
          <ul class="list-unstyled">
            <li class="my-2">
              <a href=""><img src="../client/assets/images/logo.png" width="200" class="img-fluid" id="logo-banner" alt="Logo Banner"></a>
            </li>
          </ul>
        </div>
        <div class="col-md-3 mx-auto mb-3">
          <h5 class="text-uppercase mb-4 text-cream fw-bold">Recursos</h5>
          <ul class="list-unstyled">
            <li class="my-2"><a href="#" class="text-primary text-decoration-none">Acerca de nosotros</a><br></li>
            <li class="my-2"><a href="#" class="text-primary text-decoration-none">Contáctanos</a><br></li>
            <li class="my-2"><a href="#" class="text-primary text-decoration-none">Preguntas frecuentes</a><br></li>
          </ul>
        </div>
        <div class="col-md-3 mx-auto mb-3">
          <h5 class="text-uppercase mb-4 text-cream fw-bold">Políticas</h5>
          <ul class="list-unstyled">
            <li class="my-2"><a href="#" class="text-primary text-decoration-none">Política de privacidad</a><br></li>
          </ul>
        </div>
        <div class="col-md-3 mx-auto mb-3">
          <h5 class="text-uppercase mb-4 text-cream fw-bold">Contacto</h5>
          <ul class="list-unstyled">
            <li class="my-2">
              <a href="https://www.facebook.com" target="_blank" class="d-flex justify-content-md-start justify-content-center align-items-center text-primary text-decoration-none">
                <i class='text-primary bx-sm bx bxl-facebook-square me-2'></i>Facebook
              </a>
            </li>
            <li class="my-2">
              <a href="https://www.instagram.com" target="_blank" class="d-flex justify-content-md-start justify-content-center text-primary text-decoration-none">
                <i class='text-primary bx-sm bx bxl-instagram-alt me-2' ></i>Instagram
              </a>
            </li>
            <li class="my-2">
              <a href="tel:(00)00000000" class="d-flex justify-content-md-start justify-content-center text-primary text-decoration-none">
                <i class='text-primary bx-sm bx bxs-phone me-2'></i>(00)-0000-0000
              </a>
            </li>
            <li class="my-2">
              <a href="mailto:cursotopia@gmail.com.mx" class="d-flex justify-content-md-start justify-content-center text-primary text-decoration-none">
                <i class='text-primary bx-sm bx bxs-envelope me-2' ></i>Correo electrónico
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="container">
        <div class="row pt-5 pb-3 d-flex align-items-center">
          <div class="col-md-12  text-center">

          </div>
        </div>
      </div>
      <div class="container text-center img-responsive">
        <p class="text-cream mb-0">&copy; 2023 Curstopia. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>
</body>

</html>