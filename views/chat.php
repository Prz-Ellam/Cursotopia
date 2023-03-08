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
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
  <link rel="stylesheet" href="../dist/assets/chat.css">
  <script defer type="module" src="../dist/javascript/chat.js"></script>
</head>
<body>
  <?= $this->render("partials/navbar") ?>

  <main class="container-fluid">
    <div class="row no-gutters flex-nowrap">
      <section class="col-12 col-lg-4 rounded-0 d-md-block card border-0 collapse overflow-auto chat-section border-end" id="chat-section">
        
        <input type="search" name="search" class="bg-light form-control border-0 shadow-none my-3" placeholder="Buscar personas...">
        
        <div class="chat-drawer p-2 border-bottom rounded-0">
          <a
            href="#"
            class="text-decoration-none d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target="chat-section"
            aria-expanded="false"
            aria-controls="collapseExample"
          >
            <div class="d-flex flex-row flex-nowrap align-items-center overflow-hidden">
              <img
                src="../client/assets/images/perfil.png"
                alt="avatar"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
              >
              <div class="overflow-hidden text-nowrap">
                <p class="h5 fw-bold mb-0">Kevin Gold</p>
                <small class="text-primary fw-bold mb-0">Hola, ¿cómo estas?</small>
              </div>
            </div>
            <div>
              <p class="small text-muted mb-1 text-end">23/02/21 04:00</p>
              <span class="badge rounded-pill bg-danger float-end">1</span>
            </div>
          </a>
        </div>

        <div class="chat-drawer p-2 border-bottom">
          <a
            href="#"
            class="text-decoration-none d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target="chat-section"
            aria-expanded="false"
            aria-controls="collapseExample"
          >
            <div class="d-flex flex-row flex-nowrap align-items-center overflow-hidden">
              <img
                src="../client/assets/images/perfil.png"
                alt="avatar"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
              >
              <div class="overflow-hidden text-nowrap">
                <p class="h5 mb-0">Kevin Gold</p>
                <small class="text-muted mb-0">Hola, ¿cómo estas?</small>
              </div>
            </div>
            <div>
              <p class="small text-muted mb-1 text-end">23/02/21 04:00</p>
              <span class="badge rounded-pill bg-danger float-end visibility-hidden">0</span>
            </div>
          </a>
        </div>

        <div class="chat-drawer p-2 border-bottom">
          <a
            href="#"
            class="text-decoration-none d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target=".chat-section"
            aria-expanded="false"
            aria-controls="collapseExample"
          >
            <div class="d-flex flex-row flex-nowrap align-items-center overflow-hidden">
              <img
                src="../client/assets/images/perfil.png"
                alt="avatar"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
              >
              <div class="overflow-hidden text-nowrap">
                <p class="h5 mb-0">Kevin Gold</p>
                <small class="text-muted mb-0">Hola, ¿cómo estas?</small>
              </div>
            </div>
            <div>
              <p class="small text-muted mb-1 text-end">23/02/21 04:00</p>
              <span class="badge rounded-pill bg-danger float-end visibility-hidden">1</span>
            </div>
          </a>
        </div>

        <div class="chat-drawer p-2 border-bottom">
          <a
            href="#"
            class="text-decoration-none d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target=".chat-section"
            aria-expanded="false"
            aria-controls="collapseExample"
          >
            <div class="d-flex flex-row flex-nowrap align-items-center overflow-hidden">
              <img
                src="../client/assets/images/perfil.png"
                alt="avatar"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
              >
              <div class="overflow-hidden text-nowrap">
                <p class="h5 mb-0">Kevin Gold</p>
                <small class="text-muted mb-0">Hola, ¿cómo estas?</small>
              </div>
            </div>
            <div>
              <p class="small text-muted mb-1 text-end">23/02/21 04:00</p>
              <span class="badge rounded-pill bg-danger float-end visibility-hidden">1</span>
            </div>
          </a>
        </div>

        <div class="chat-drawer p-2 border-bottom">
          <a
            href="#"
            class="text-decoration-none d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target=".chat-section"
            aria-expanded="false"
            aria-controls="collapseExample"
          >
            <div class="d-flex flex-row flex-nowrap align-items-center overflow-hidden">
              <img
                src="../client/assets/images/perfil.png"
                alt="avatar"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
              >
              <div class="overflow-hidden text-nowrap">
                <p class="h5 mb-0">Kevin Gold</p>
                <small class="text-muted mb-0">Hola, ¿cómo estas?</small>
              </div>
            </div>
            <div>
              <p class="small text-muted mb-1 text-end">23/02/21 04:00</p>
              <span class="badge rounded-pill bg-danger float-end visibility-hidden">1</span>
            </div>
          </a>
        </div>

        <div class="chat-drawer p-2 border-bottom">
          <a
            href="#"
            class="text-decoration-none d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target=".chat-section"
            aria-expanded="false"
            aria-controls="collapseExample"
          >
            <div class="d-flex flex-row flex-nowrap align-items-center overflow-hidden">
              <img
                src="../client/assets/images/perfil.png"
                alt="avatar"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
              >
              <div class="overflow-hidden text-nowrap">
                <p class="h5 mb-0">Kevin Gold</p>
                <small class="text-muted mb-0">Hola, ¿cómo estas?</small>
              </div>
            </div>
            <div>
              <p class="small text-muted mb-1 text-end">23/02/21 04:00</p>
              <span class="badge rounded-pill bg-danger float-end visibility-hidden">1</span>
            </div>
          </a>
        </div>

        <div class="chat-drawer p-2 border-bottom">
          <a
            href="#"
            class="text-decoration-none d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target=".chat-section"
            aria-expanded="false"
            aria-controls="collapseExample"
          >
            <div class="d-flex flex-row flex-nowrap align-items-center overflow-hidden">
              <img
                src="../client/assets/images/perfil.png"
                alt="avatar"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
              >
              <div class="overflow-hidden text-nowrap">
                <p class="h5 mb-0">Kevin Gold</p>
                <small class="text-muted mb-0">Hola, ¿cómo estas?</small>
              </div>
            </div>
            <div>
              <p class="small text-muted mb-1 text-end">23/02/21 04:00</p>
              <span class="badge rounded-pill bg-danger float-end visibility-hidden">1</span>
            </div>
          </a>
        </div>

        <div class="chat-drawer p-2 border-bottom">
          <a
            href="#"
            class="text-decoration-none d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target=".chat-section"
            aria-expanded="false"
            aria-controls="collapseExample"
          >
            <div class="d-flex flex-row flex-nowrap align-items-center overflow-hidden">
              <img
                src="../client/assets/images/perfil.png"
                alt="avatar"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
              >
              <div class="overflow-hidden text-nowrap">
                <p class="h5 mb-0">Kevin Gold</p>
                <small class="text-muted mb-0">Hola, ¿cómo estas?</small>
              </div>
            </div>
            <div>
              <p class="small text-muted mb-1 text-end">23/02/21 04:00</p>
              <span class="badge rounded-pill bg-danger float-end visibility-hidden">1</span>
            </div>
          </a>
        </div>

        <div class="chat-drawer p-2 border-bottom">
          <a
            href="#"
            class="text-decoration-none d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target=".chat-section"
            aria-expanded="false"
            aria-controls="collapseExample"
          >
            <div class="d-flex flex-row flex-nowrap align-items-center overflow-hidden">
              <img
                src="../client/assets/images/perfil.png"
                alt="avatar"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
              >
              <div class="overflow-hidden text-nowrap">
                <p class="h5 mb-0">Kevin Gold</p>
                <small class="text-muted mb-0">Hola, ¿cómo estas?</small>
              </div>
            </div>
            <div>
              <p class="small text-muted mb-1 text-end">23/02/21 04:00</p>
              <span class="badge rounded-pill bg-danger float-end visibility-hidden">1</span>
            </div>
          </a>
        </div>

        <div class="chat-drawer p-2 border-bottom">
          <a
            href="#"
            class="text-decoration-none d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse"
            data-bs-target=".chat-section"
            aria-expanded="false"
            aria-controls="collapseExample"
          >
            <div class="d-flex flex-row flex-nowrap align-items-center overflow-hidden">
              <img
                src="../client/assets/images/perfil.png"
                alt="avatar"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
              >
              <div class="overflow-hidden text-nowrap">
                <p class="h5 mb-0">Kevin Gold</p>
                <small class="text-muted mb-0">Hola, ¿cómo estas?</small>
              </div>
            </div>
            <div>
              <p class="small text-muted mb-1 text-end">23/02/21 04:00</p>
              <span class="badge rounded-pill bg-danger float-end visibility-hidden">1</span>
            </div>
          </a>
        </div>

      </section>
      <section class="col-12 col-lg-8 rounded-0 card border-0 overflow-auto chat-section">
        <div class="d-flex justify-content-start align-items-center mt-3">
          <button
            class="d-block d-md-none btn px-0 border-0"
            id="collapse-chat-buttom"
            data-bs-toggle="collapse"
            data-bs-target=".chat-section"
            aria-expanded="false"
            aria-controls="collapseExample"
          >
            <i class='bx-md bx bx-chevron-left'></i>
          </button>
          <img
            class="img-fluid rounded-circle actual-chat-user-image"
            src="../client/assets/images/perfil.png"
            alt="Perfil"
          >
          <span class="h5 mb-0 ms-2 text-black"><b>Kevin Gold</b></span>
        </div>
        <hr>
        <div class="overflow-auto p-2 h-100 chat-box" id="message-box">

          <div class="d-flex justify-content-end my-3">
            <small
              class="bg-primary text-light p-2 rounded-pill overflow-auto"
              data-bs-toggle="tooltip"
              data-bs-placement="left"
              data-bs-title="26 de enero de 2023 a las 02:21">
              message
            </small>
          </div>

          <div class="d-flex justify-content-end my-3">
            <small
              class="bg-primary text-light p-2 rounded-pill overflow-auto"
              data-bs-toggle="tooltip"
              data-bs-placement="left"
              data-bs-title="26 de enero de 2023 a las 02:21">
              message
            </small>
          </div>
          
          <div class="d-flex justify-content-end my-3">
            <small
              class="bg-primary text-light p-2 rounded-pill overflow-auto"
              data-bs-toggle="tooltip"
              data-bs-placement="left"
              data-bs-title="26 de enero de 2023 a las 02:21">
              message
            </small>
          </div>

          <div class="d-flex justify-content-end my-3">
            <small
              class="bg-primary text-light p-2 rounded-pill overflow-auto"
              data-bs-toggle="tooltip"
              data-bs-placement="left"
              data-bs-title="26 de enero de 2023 a las 02:21">
              message
            </small>
          </div>

          <div class="d-flex justify-content-start my-3">
            <small
              class="bg-secondary text-light p-2 rounded-pill overflow-auto"
              data-bs-toggle="tooltip"
              data-bs-placement="right"
              data-bs-title="26 de enero de 2023 a las 02:21">
              message
            </small>
          </div>

          <div class="d-flex justify-content-start my-3">
            <small
              class="bg-secondary text-light p-2 rounded-pill overflow-auto"
              data-bs-toggle="tooltip"
              data-bs-placement="right"
              data-bs-title="26 de enero de 2023 a las 02:21">
              message
            </small>
          </div>

          <div class="d-flex justify-content-start my-3">
            <small
              class="bg-secondary text-light p-2 rounded-pill overflow-auto"
              data-bs-toggle="tooltip"
              data-bs-placement="right"
              data-bs-title="26 de enero de 2023 a las 02:21">
              message
            </small>
          </div>

          <div class="d-flex justify-content-start my-3">
            <small
              class="bg-secondary text-light p-2 rounded-pill overflow-auto"
              data-bs-toggle="tooltip"
              data-bs-placement="right"
              data-bs-title="26 de enero de 2023 a las 02:21">
              message
            </small>
          </div>

          <div class="d-flex justify-content-start my-3">
            <small
              class="bg-secondary text-light p-2 rounded-pill overflow-auto"
              data-bs-toggle="tooltip"
              data-bs-placement="right"
              data-bs-title="26 de enero de 2023 a las 02:21">
              message
            </small>
          </div>

        </div>
        <hr class="mb-1 text-light">
        <div class="input-group mb-3">
          <input type="text" id="message" class="bg-light form-control border-0 shadow-none" placeholder="Escribe un mensaje"
            aria-label="Enviar mensaje" aria-describedby="basic-addon2">
          <button class="btn btn-primary shadow-none" id="send-message"><i class="bx bxs-send"></i></button>
        </div>
      </section>
    </div>
  </main>
</body>
<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</html>