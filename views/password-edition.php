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
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <script src="https://kit.fontawesome.com/812dd4b211.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
  
  <link rel="stylesheet" href="../dist/assets/password-edition.css">
  <script defer type="module" src="../dist/javascript/password-edition.js"></script>
</head>
<body>
  <?= $this->render("partials/navbar") ?>
  <main class="container my-5">

<!-- 
    <div class="px-3 mt-3 mb-0 alert alert-secondary border-0 p-2" role="alert">
      <a href="instructor-profile" class="text-decoration-none text-primary">
        Mi cuenta
      </a> / Editar contraseña
    </div> -->

    <div class="row d-flex justify-content-center">

      <form action="" class="col-lg-6 col-md-6" id="password-edition-form">
            
        <div class="border-3 border-bottom border-primary text-center mb-4">
          <h1>Editar contraseña</h1>
        </div>

        <div class="mb-4">
          <label for="old-password" role="button" class="form-label">Contraseña anterior</label>
          <div class="input-group">
            <input type="password" name="old-password" id="old-password" class="form-control">
            <button type="button" class="btn btn-primary btn-password" id="old-password-button"
              ct-target="old-password">
              <i class="fa-solid fa-eye-slash fa-eye"></i>
            </button>
          </div>
        </div>
    
        <div class="mb-4">
          <label for="new-password" role="button" class="form-label">Confirmar contraseña</label>
          <div class="input-group">
            <input type="password" name="new-password" id="new-password" class="form-control">
            <button type="button" class="btn btn-primary btn-password" id="new-password-button"
              ct-target="new-password">
              <i class="fa-solid fa-eye-slash fa-eye"></i>
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
          <label for="confirm-new-password" role="button" class="form-label">Confirmar contraseña</label>
          <div class="input-group">
            <input type="password" name="confirm-new-password" id="confirm-new-password" class="form-control">
            <button type="button" class="btn btn-primary btn-password" id="confirm-new-password-button"
              ct-target="confirm-new-password">
              <i class="fa-solid fa-eye-slash fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="d-grid mb-4">
          <button type="submit" class="btn btn-primary rounded-pill">Actualizar contraseña</button>
        </div>

        <!--
        <a href="" class="d-block text-primary text-center text-decoration-none">¿Olvidaste tú contraseña?</a>
        -->
      </form>
    </div>
  </main>
  <?= $this->render("partials/footer") ?>
</body>
</html>