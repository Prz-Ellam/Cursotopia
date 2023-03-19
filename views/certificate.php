<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->env("APP_NAME") ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <?= $this->link("styles/pages/certificate.css") ?>
  <?= $this->script("javascript/certificate.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>
  <section class="container mb-4">
    <img
      src="../client/assets/images/certificate.png"
      alt="Certificado"
      class="img-fluid w-100 h-100 mb-4"
      id="certificate"
    >
    <div class="d-flex justify-content-end">
      <button class="btn fb-share-button me-3">Compartir en Facebook</button>
      <button class="btn btn-primary rounded-pill">Descargar como PDF</button>
    </div>
  </section>
  <?= $this->render("partials/footer") ?>
</body>
</html>