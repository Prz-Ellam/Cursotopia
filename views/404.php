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

  <!-- AOS -->
  <link rel="stylesheet" href="../node_modules/aos/dist/aos.css">
  <script src="../node_modules/aos/dist/aos.js"></script>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Boxicons -->
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">

  <?= $this->link("styles/pages/404.css") ?>
  <?= $this->script("javascript/instructor-profile.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>
  <main class="container">
    <section class="row d-flex align-items-center h-100">
      <div class="col-sm-12 col-md-6">
        <h1 class="text-sm-center text-md-start mb-0">404</h1>
        <hr>
        <h2 class="text-sm-center text-md-start">No encontrado</h2>
      </div>
      <div class="col-sm-12 col-md-6">
        <img src="../client/assets/images/404.svg" alt="404 Not Found" class="img-fluid">
      </div>
    </section>
  </main>
  <?= $this->render("partials/footer") ?>
</body>
</html>