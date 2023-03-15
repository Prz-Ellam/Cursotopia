<?php use Cursotopia\Helpers\Auth; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
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

  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css" />
  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../dist/assets/student-profile.css">
	<link rel="stylesheet" href="../client/styles/pages/instructor-profile.css" />
	<link rel="stylesheet" href="../dist/assets/instructor-profile-seen-by-others.css">
	<link rel="stylesheet" href="../client/styles/pages/student-profile-seen-by-others.css">
  <script src="../dist/javascript/instructor-profile.js"></script>
</head>
<body>
	<?= $this->render('partials/navbar') ?>
	<?php if($this->user["userRole"] === 2 && $this->isMe): ?>
		<?= $this->render('instructor-profile') ?>
	<?php elseif($this->user["userRole"] === 3 && $this->isMe): ?>
		<?= $this->render('student-profile') ?>
	<?php elseif($this->user["userRole"] === 2): ?>
		<?= $this->render('instructor-profile-seen-by-others') ?>
	<?php else: ?>
		<?= $this->render('student-profile-seen-by-others') ?>
	<?php endif ?>
	<?= $this->render('partials/footer') ?>
</body>
</html>