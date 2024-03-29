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
  
  <script src="https://kit.fontawesome.com/812dd4b211.js" crossorigin="anonymous"></script>

  <?= $this->link("styles/pages/login.css") ?>
  <?= $this->script("javascript/login.js") ?>
</head>
<body>
  <main class="container">
    <section class="row d-flex align-items-center justify-content-center vh-100">
      <form action="#" class="bg-white rounded-3 p-5 col-lg-5 col-md-7 shadow-lg" id="login-form" data-aos="fade-up">
        <h1 class="text-center">Inicia sesión</h1>
        <hr>
        <div class="mb-4">
          <label for="email" role="button" class="form-label d-flex align-items-center">
            <i class="bx bxs-envelope me-1"></i>
            <span>Correo electrónico</span>
          </label>
          <input type="email" name="email" id="email" class="form-control" 
            placeholder="example@domain.com" autocomplete="off">
        </div>
        <div class="mb-5">
          <label for="password" role="button" class="form-label d-flex align-items-center">
            <i class="bx bxs-key me-1"></i>
            <span>Contraseña</span>
          </label>
          <div class="input-group">
            <input type="password" name="password" id="password" class="form-control">
            <button type="button" class="btn btn-primary btn-password" 
              id="password-button">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
        </div>
        <div class="d-grid mb-4">
          <button type="submit" id="login-btn"
            class="btn btn-primary rounded-pill">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="login-spinner"></span>
            <span>Iniciar sesión</span>
          </button>
        </div>
        <p class="text-center mb-0">¿Aún no tienes una cuenta?</p>
        <a href="/signup" class="d-block text-center text-decoration-none text-primary">
          ¡Registrate aquí!
        </a>
      </form>
    </section>
  </main>
</body>
</html>