<?php
  use Cursotopia\Helpers\Format;
?>
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
  
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="../client/styles/pages/payment-method.css">

  <!-- PayPal -->
  <script src="https://www.paypal.com/sdk/js?client-id=AYRWL7VDLGBBSSSutwgu3nPO8ZDZKNGCiON9pO_X-dGx3lgkWMLL2xlQjDycSG5qA3bh4IRsjMMgHunl"></script>
  <script src="https://www.paypalobjects.com/api/checkout.js"></script>

  <script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  
  <?= $this->script("javascript/payment-method.js") ?>
  <script>
    const PRICE = <?=$this->course["price"]?>;
  </script>
</head>
<body>
  <?= $this->render("partials/navbar") ?>

  <main class="container my-4">
    <div class="row">
      <div class="border-3 border-bottom border-primary text-center mb-3">
        <h1>Método de pago</h1>
      </div>
      <form class="col-xxl-6 col-lg-5 col-md-12 col-sm-12" id="payment-method-form">
        <div class="row mt-3 mb-3">
          <div class="col-12">
            <div class="form-check">
              <input checked autocomplete="off" class="form-check-input" name="paymentMethodId" type="radio" id="chk-card" data-bs-toggle="collapse" data-bs-target=".checkout-section" aria-expanded="false" aria-controls="checkout-section" value="1">
              <label class="form-check-label" for="chk-card">Tarjeta de crédito/debito</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" name="paymentMethodId" type="radio" id="chk-paypal" autocomplete="off" data-bs-toggle="collapse" data-bs-target=".checkout-section" aria-expanded="false" aria-controls="checkout-section" value="2">
              <!-- TODO: ID hardcodeados -->
              <label class="form-check-label" for="chk-paypal">Paypal</label>
            </div>
          </div>
        </div>
        <div class="row collapse show checkout-section">
          <input type="hidden" name="amount" value="<?= $this->course["price"] ?>">
          <div class="col-6 mb-4">
            <label for="name" class="form-label" role="button">Nombre de la tarjeta</label>
            <input type="text" name="name" id="name" class="form-control">
          </div>
          <div class="col-6 mb-4">
            <label for="curp" class="form-label" role="button">Curp</label>
            <input type="text" name="curp" id="curp" class="form-control">
          </div>
          <div class="col-12 mb-4">
            <label for="cardNumber" class="form-label" role="button">Número de tarjeta</label>
            <input type="text" name="card-number" id="card-number" class="form-control">
          </div>

          <div class="col-6 mb-4">
            <label for="cvv" class="form-label" role="button">CVC/CVV</label>
            <input type="text" name="cvv" id="cvv" class="form-control">
          </div>
          <div class="col-6 mb-4">
            <label for="expiration" class="form-label" role="button">Fecha de vencimiento</label>
            <div class="form-control exp-wrapper">
              <input autocomplete="off" class="bg-light exp" id="month" maxlength="2" pattern="[0-9]*" inputmode="numerical" placeholder="MM" type="text" data-pattern-validate name="month">
              <input autocomplete="off" class="bg-light exp" id="year" maxlength="2" pattern="[0-9]*" inputmode="numerical" placeholder="YY" type="text" data-pattern-validate name="year">
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
            <img class="product-img" src="api/v1/images/<?= Format::sanitize($this->course["imageId"]) ?>" alt="Curso">
          </div>
          <div class="col-8">
            <label for="inputEmail4" class="form-label">
              <?= Format::sanitize($this->course["title"]) ?>
            </label>
          </div>
          <div class="col-2 ms-auto">
            <label for="inputEmail4" class="form-label"><?= Format::money($this->course["price"]) ?></label>
          </div>
        </div>
        <div class="d-flex mt-3">
          <button type="submit" id="payment-btn"
            class="btn btn-primary rounded-pill w-100">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="payment-spinner"></span>
            Hacer pago
          </button>
        </div>
      </form>
      <div class="col-lg-7 col-xxl-6 col-md-12">
        <img src="../client/assets/images/online-shopping.png" alt="Pago" class="img-fluid">
      </div>
    </div>
  </main>

  <?= $this->render("partials/footer") ?>
</body>
</html>