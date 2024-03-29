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

  <?= $this->link("styles/pages/password-edition.css") ?>
  <?= $this->script("javascript/password-edition.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>
  <main class="container my-5">

<!-- 
    <div class="px-3 mt-3 mb-0 alert alert-secondary border-0 p-2" role="alert">
      <a href="/instructor-profile" class="text-decoration-none text-primary">
        Mi cuenta
      </a> / Editar contraseña
    </div> -->

    <div class="row d-flex justify-content-center">
      <form action="" class="col-lg-6 col-md-6" id="password-edition-form">
        <div class="border-3 border-bottom border-primary text-center mb-4">
          <h1>Editar contraseña</h1>
        </div>

        <input type="hidden" name="id" value="<?= $this->session("id") ?>">
        <div class="mb-4">
          <label for="old-password" role="button" class="form-label">Contraseña anterior</label>
          <div class="input-group">
            <input type="password" name="oldPassword" id="old-password" class="form-control">
            <button type="button" class="btn btn-primary btn-password" id="old-password-button"
              role="button">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
        </div>
    
        <div class="mb-4">
          <label for="new-password" role="button" class="form-label">Nueva contraseña</label>
          <div class="input-group">
            <input type="password" name="newPassword" id="new-password" class="form-control">
            <button type="button" class="btn btn-primary btn-password" id="new-password-button"
              role="button">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <ul class="mt-1">
            <!-- <li class="lower">Una minuscula</li> -->
            <li id="password-length">Mínimo 8 caracteres</li>
            <li id="password-mayus">Una mayuscula</li>
            <li id="password-number">Un número</li>
            <li id="password-specialchar">Una caracter especial</li>
          </ul>
        </div>
    
        <div class="mb-4">
          <label for="confirm-new-password" role="button" class="form-label">Confirmar nueva contraseña</label>
          <div class="input-group">
            <input type="password" name="confirmNewPassword" id="confirm-new-password" class="form-control">
            <button type="button" class="btn btn-primary btn-password" id="confirm-new-password-button"
              role="button">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="d-grid mb-4">
          <button type="submit" id="password-edition-btn" 
            class="btn btn-primary rounded-pill">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="password-edition-spinner"></span>
            <span>Actualizar contraseña</span>
          </button>
        </div>
      </form>
    </div>
  </main>
  <?= $this->render("partials/footer") ?>
</body>
</html>