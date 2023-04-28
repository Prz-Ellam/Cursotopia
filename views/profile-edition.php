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
  
  <!-- Boxicons --> 
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  
  <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  
  <?= $this->link("styles/pages/profile-edition.css") ?>
  <?= $this->script("javascript/profile-edition.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>

  <main class="container my-5">
    <div class="row d-flex justify-content-center">
      <div action="#" class="col-lg-7 col-md-7">
        <div class="border-3 border-bottom border-primary text-center mb-3">
          <h1>Editar perfil</h1>
        </div>
        <div class="form-group text-center">
          <div class="position-relative">
            <label for="profile-picture" role="button"
              class="profile-picture-label text-white position-absolute rounded-circle">
            </label>
            <div class="spinner-border text-white" id="change-profile-picture-spinner" role="status"></div>
            <img 
              class="img img-fluid rounded-circle mb-1" 
              id="picture-box" 
              src="api/v1/images/<?= $this->user["profilePicture"] ?>"
              alt="Profile picture"
            >
          </div>
          <input type="file" accept="image/png, image/jpeg, image/jpg"
            class="form-control shadow-none rounded-1 position-absolute" name="profile-picture" id="profile-picture">
          <label for="profile-picture" role="button">Cambiar foto de perfil</label>
        </div>
        <form action="#" id="profile-edition-form" class="user-form">
          <input type="hidden" name="id" value="<?= $this->user["id"] ?>">
          <div class="text-center mb-4">
            <input type="hidden" name="profilePicture" id="profile-picture-id" 
              autocomplete="off" value="<?= $this->user["profilePicture"] ?>">
          </div>
          <div class="row">
            <div class="col-6 mb-4">
              <label for="name" role="button" class="form-label">Nombre</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Jon"
                value="<?= $this->user["name"] ?>">
            </div>
            
            <div class="col-6 mb-4">
              <label for="last-name" role="button" class="form-label">Apellido</label>
              <input type="text" name="lastName" id="last-name" class="form-control" 
                placeholder="Doe" value="<?= $this->user["lastName"] ?>">
            </div>

            <div class="col-6 mb-4">
              <label for="gender" role="button" class="form-label">Género</label>
              <select name="gender" id="gender" class="form-select">
                <option value="">Seleccionar</option>
                <option value="Masculino" <?= ("Masculino" == $this->user["gender"]) ? 'selected' : '' ?>>Másculino</option>
                <option value="Femenino" <?= ("Femenino" == $this->user["gender"]) ? 'selected' : '' ?>>Femenino</option>
                <option value="Otro" <?= ("Otro" == $this->user["gender"]) ? 'selected' : '' ?>>Otro</option>
              </select>
            </div>
            
            <div class="col-6 mb-4">
              <label for="birth-date" role="button" class="form-label">Fecha de nacimiento</label>
              <input type="date" name="birthDate" id="birth-date" 
                class="bg-light form-control border-0 shadow-none"
                value="<?= $this->user["birthDate"] ?>">
            </div>
            
            <div class="col-12 mb-4">
              <label for="email" role="button" class="form-label">Correo electrónico</label>
              <input type="email" name="email" id="email" class="form-control" 
                placeholder="example@domain.com" value="<?= $this->user["email"] ?>">
            </div>
          </div>
          <div class="d-grid mb-4">
            <button type="submit" class="btn btn-primary rounded-pill" id="submit-btn">Actualizar perfil</button>
          </div>
        </form>
      </div>
    </div>
  </main>
  <?= $this->render("partials/footer") ?>
</body>
</html>