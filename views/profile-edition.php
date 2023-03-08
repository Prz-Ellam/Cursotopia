<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cursotopia</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <link rel="stylesheet" href="../dist/assets/profile-edition.css">
  <script defer type="module" src="../dist/javascript/profile-edition.js"></script>
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
              class="profile-picture-label text-white position-absolute rounded-circle"></label>
            <img class="img img-fluid rounded-circle mb-1" id="picture-box" src="../client/assets/images/perfil.png"
              alt="Profile picture">
          </div>
          <input type="file" accept="image/png, image/gif, image/jpeg, image/jpg"
            class="form-control shadow-none rounded-1 position-absolute" name="profile-picture" id="profile-picture">
          <label for="profile-picture" role="button">Foto de perfil</label>
        </div>
        <form action="#" id="profile-edition-form" class="user-form">
          <div class="text-center mb-4">
            <input type="hidden" name="profile-picture" id="profile-picture-id" autocomplete="off">
          </div>
          <div class="row">
            <div class="col-6 mb-4">
              <label for="name" role="button" class="form-label">Nombre</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Jon">
            </div>
            
            <div class="col-6 mb-4">
              <label for="last-name" role="button" class="form-label">Apellido</label>
              <input type="text" name="last-name" id="last-name" class="form-control" placeholder="Doe">
            </div>
            
            <div class="col-6 mb-4">
              <label for="gender" role="button" class="form-label">Género</label>
              <select name="gender" id="gender" class="form-select">
                <option value="0" selected>Seleccionar</option>
                <option value="1">Másculino</option>
                <option value="2">Femenino</option>
                <option value="3">Otro</option>
              </select>
            </div>
            
            <div class="col-6 mb-4">
              <label for="birth-date" role="button" class="form-label">Fecha de nacimiento</label>
              <input type="date" name="birth-date" id="birth-date" class="bg-light form-control border-0 shadow-none">
            </div>
            
            <div class="col-12 mb-4">
              <label for="email" role="button" class="form-label">Correo electrónico</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="example@domain.com">
            </div>
          </div>
          <div class="d-grid mb-4">
            <button type="submit" class="btn btn-primary rounded-pill">Actualizar perfil</button>
          </div>
        </form>
      </div>
    </div>
  </main>
  <?= $this->render("partials/footer") ?>
</body>
</html>