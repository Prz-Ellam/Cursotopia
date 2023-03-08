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
	<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="../client/styles/pages/payment-method.css">

	<!-- PayPal -->
	<script src="https://www.paypal.com/sdk/js?client-id=AYRWL7VDLGBBSSSutwgu3nPO8ZDZKNGCiON9pO_X-dGx3lgkWMLL2xlQjDycSG5qA3bh4IRsjMMgHunl"></script>
  <script src="https://www.paypalobjects.com/api/checkout.js"></script>

	<script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script defer type="module" src="../dist/javascript/payment-method.js"></script>
</head>

<body>
  <?= $this->render("partials/navbar") ?>

	<!-- Contenido -->
	<main class="container my-4">
		<div class="row">
			<div class="border-3 border-bottom border-primary text-center mb-3">
				<h1>Método de pago</h1>
			</div>
			<form class="col-xxl-6 col-lg-5 col-md-12 col-sm-12" id="payment-method-form">
				<div class="row mt-3 mb-3">
					<div class="col-12">
						<div class="form-check">
							<input
								checked
								autocomplete="off"
								class="form-check-input"
								name="method" type="radio" id="chk-card"
								data-bs-toggle="collapse"
								data-bs-target=".checkout-section"
								aria-expanded="false" aria-controls="checkout-section"
							>
							<label class="form-check-label" for="chk-card">Tarjeta de crédito/debito</label>
						</div>
						<div class="form-check">
							<input class="form-check-input"
								name="method" type="radio" id="chk-paypal"
								autocomplete="off"
								data-bs-toggle="collapse"
								data-bs-target=".checkout-section"
								aria-expanded="false" aria-controls="checkout-section"
							>
							<label class="form-check-label" for="chk-paypal">Paypal</label>
						</div>
					</div>
				</div>
				<div class="row collapse show checkout-section">
					<div class="col-6 mb-4">
						<label for="name" class="form-label" role="button">Nombre de la tarjeta</label>
						<input type="text" name="name" id="name" class="form-control">
					</div>
					<div class="col-6 mb-4">
						<label for="curp" class="form-label" role="button">Curp</label>
						<input type="text" name="curp" id="curp" class="form-control">
					</div>
					<div class="col-12 mb-4">
						<label for="card-number" class="form-label" role="button">Número de tarjeta</label>
						<input type="text" name="card-number" id="card-number" class="form-control">
					</div>

					<div class="col-6 mb-4">
						<label for="cvv" class="form-label" role="button">CVC/CVV</label>
						<input type="text" name="cvv" id="cvv" class="form-control">
					</div>
					<div class="col-6 mb-4">
						<label for="expiration" class="form-label" role="button">Fecha de vencimiento</label>
						<div class="form-control exp-wrapper">
							<input autocomplete="off" class="bg-light exp" id="month" maxlength="2" pattern="[0-9]*" inputmode="numerical"
								placeholder="MM" type="text" data-pattern-validate
								name="month">
							<input autocomplete="off" class="bg-light exp" id="year" maxlength="2" pattern="[0-9]*" inputmode="numerical"
								placeholder="YY" type="text" data-pattern-validate
								name="year">
						</div>
					</div>
				</div>
				<div class="row collapse checkout-section" id="paypal-section">
				</div>
				<div class="row mb-3">
					<div class="col-md-12">
						<h4>Detalles del pedido</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-2">
						<img class="product-img"
							src="https://import.cdn.thinkific.com/220744/courses/557614/hr1BWk5LTF2jiAziFPH0_aprende-a-programar-de-cero-con-python-min.jpg"
							alt="">
					</div>
					<div class="col-8">
						<label for="inputEmail4" class="form-label">Introducción a la programación</label>
					</div>
					<div class="col-2 ms-auto">
						<label for="inputEmail4" class="form-label">$1000.00 MXN</label>
					</div>
				</div>
				<div class="d-flex mt-3">
					<button type="submit" class="btn btn-primary rounded-pill w-100">Hacer pago</button>
				</div>
			</form>
			<div class="col-lg-7 col-xxl-6 col-md-12">
				<img
					src="../client/assets/images/online-shopping.png"
					alt="Pago"
					class="img-fluid"
				>
			</div>
		</div>
	</main>

  <?= $this->render("partials/footer") ?>
</body>

</html>