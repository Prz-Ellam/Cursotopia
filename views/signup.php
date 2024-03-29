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

  <!-- FontAwesome -->
  <script defer src="https://kit.fontawesome.com/812dd4b211.js" crossorigin="anonymous"></script>
  
  <?= $this->link("styles/pages/signup.css") ?>
  <?= $this->script("javascript/signup.js") ?>
</head>
<body>
  <main class="container my-4">
    <section class="row d-flex justify-content-center">
      <div class="bg-white rounded-3 p-5 col-lg-8 col-md-8" data-aos="fade-up">
        <h1 class="text-center">Crea una nueva cuenta</h1>
        <hr>
        <form action="#" id="signup-form" class="user-form">
          <div class="form-group text-center">
            <div class="position-relative">
              <label for="profile-picture" role="button"
                class="profile-picture-label text-white position-absolute rounded-circle">
              </label>
              <img 
                class="img img-fluid rounded-circle mb-1" 
                id="picture-box" 
                src="<?= $this->asset("assets/images/perfil.png") ?>"
                alt="Profile picture"
              >
            </div>
            <div>
              <input 
                type="file" 
                accept="image/png, image/jpeg, image/jpg"
                class="form-control position-absolute" 
                name="image" 
                id="profile-picture"
                autocomplete="off"
              >
              <label for="profile-picture" role="button" class="">
                <i class="fa-sm fa-solid fa-image"></i>
                <span>Foto de perfil</span>
              </label>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-sm-6 col-12 mb-4">
              <label for="name" role="button" class="form-label">
                <i class="fa-sm fa-solid fa-user"></i>
                <span>Nombre(s)</span>
              </label>
              <input type="text" name="name" id="name" class="form-control"
                placeholder="Jon">
            </div>
            <div class="col-sm-6 col-12 mb-4">
              <label for="last-name" role="button" class="form-label">
                <i class="fa-sm fa-solid fa-users"></i>
                <span>Apellido(s)</span>
              </label>
              <input type="text" name="lastName" id="last-name" class="form-control"
                placeholder="Doe">
            </div>
            <div class="col-lg-4 col-12 mb-4">
              <label for="user-role" role="button" class="form-label">
                <i class="fa-sm fa-solid fa-cubes"></i>
                <span>Rol de usuario</span>
              </label>
              <select name="role" id="user-role" class="form-select">
                <option value="0" selected>Seleccionar</option>
                <?php foreach($this->roles as $role): ?>
                <option value="<?= $role["id"] ?>"><?= $role["name"] ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-lg-4 col-12 mb-4">
              <label for="gender" role="button" class="form-label">
                <i class="fa-sm fa-solid fa-venus-mars"></i>
                <span>Género</span>
              </label>
              <select name="gender" id="gender" class="form-select">
                <option value="" selected>Seleccionar</option>
                <option value="Masculino">Másculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
              </select>
            </div>
            <div class="col-lg-4 col-12 mb-4">
              <label for="birthDate" role="button" class="form-label">
                <i class="fa-sm fa-solid fa-calendar"></i>
                <span>Fecha de nacimiento</span>
              </label>
              <input type="date" name="birthDate" id="birth-date" class="form-control"
                value="<?= date("Y-m-d", intval(time())) ?>">
            </div>

            <div class="col-12 mb-4">
              <label for="email" role="button" class="form-label">
                <i class="fa-sm fa-solid fa-envelope"></i>
                <span>Correo electrónico</span>
              </label>
              <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control"
                placeholder="example@domain.com">
            </div>

            <div class="col-lg-6 col-12 mb-4">
              <label for="password" role="button" class="form-label">
                <i class="fa-sm fa-solid fa-key"></i>
                <span>Contraseña</span>
              </label>
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control">
                <button type="button" class="btn btn-primary btn-password" id="password-button">
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
            <div class="col-lg-6 col-12 mb-4">
              <label for="confirm-password" role="button" class="form-label">
                <i class="fa-sm fa-solid fa-lock"></i>
                <span>Confirmar contraseña</span>
              </label>
              <div class="input-group">
                <input type="password" name="confirmPassword" id="confirm-password"
                  class="form-control">
                <button type="button" class="btn btn-primary btn-password" id="confirm-password-button">
                  <i class="fa-solid fa-eye"></i>
                </button>
              </div>
            </div>
          </div>
  
          <div class="d-grid mb-4">
            <button type="submit" id="signup-btn"
              class="btn btn-primary rounded-pill">
              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="signup-spinner"></span>
              <span>Registrarse</span>
            </button>
          </div>
        </form>
        <p class="text-center mb-0">¿Ya tienes cuenta?</p>
        <a class="d-block text-center text-decoration-none text-primary" href="/login">
          ¡Inicia sesión aquí!
        </a>
      </div>
    </section>
  </main>
</body>
<script>
  const PROFILE_PICTURE = '<?= $this->asset("assets/images/perfil.png") ?>';
</script>
</html>