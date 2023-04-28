<!DOCTYPE html>
<html lang="<?= LANG ?>">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->env("APP_NAME") ?></title>

  <!-- Google Fonts --> 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">
  
  <!-- Boxicons -->
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  
  <?= $this->link("styles/pages/certificate.css") ?>
  <?= $this->script("javascript/certificate.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>
  <section class="container">
    <img
      src="<?= $this->certificate ?>"
      alt="Certificado"
      class="img-fluid w-100 h-100"
    >
  </section>
  <?= $this->render("partials/footer") ?>
</body>
</html>