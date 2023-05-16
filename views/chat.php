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
  
  <?= $this->link("styles/pages/chat.css") ?>
  <?= $this->script("javascript/chat.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>
  <main class="container-fluid">
    <div class="row no-gutters flex-nowrap">
      <section class="col-12 col-lg-4 rounded-0 d-md-block card border-0 collapse overflow-auto chat-section border-end" id="chat-section">
        
        <input 
          type="search" 
          name="search" 
          class="bg-light form-control border-0 shadow-none my-3" 
          placeholder="Buscar personas..."
          id="search-users"
        >
        
        <div id="chat-drawer">
        <?php foreach ($this->chats as $chat): ?>
        <div class="chat-drawer p-2 border-bottom" data-id="<?= $chat["id"] ?>">
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
                src="api/v1/images/<?= $chat["profilePicture"] ?>"
                alt="avatar"
                width="60"
                height="60"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
              >
              <div class="overflow-hidden text-nowrap">
                <p class="h5 fw-bold mb-0">
                  <?= $chat["user"] ?>
                </p>
                <small class="text-primary mb-0 <?= $chat["unseenMessagesCount"] !== 0 ? 'fw-bold' : '' ?>">
                  <?= $chat["lastMessageContent"] ?>
                </small>
              </div>
            </div>
            <div>
              <p class="small text-muted mb-1 text-end">
                <?= Format::datetime($chat["lastMessageCreatedAt"]) ?>
              </p>
              <?php if ($chat["unseenMessagesCount"] !== 0): ?>
              <span class="badge rounded-pill bg-danger float-end">
                <?= $chat["unseenMessagesCount"] ?>
              </span>
              <?php else: ?>
              <span style="visibility: hidden">s</span>
              <?php endif ?>
            </div>
          </a>
        </div>
        <?php endforeach ?>
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
            src="<?= $this->asset("assets/images/perfil.png") ?>"
            alt="Perfil"
          >
          <span class="h5 mb-0 ms-2 text-black fw-bold actual-chat-user-name"></span>
          <input type="hidden" id="actual-chat-id">
        </div>
        <hr>
        <div class="overflow-auto p-2 h-100 chat-box" id="message-box">

        </div>
        <hr class="mb-1 text-light">
        <div class="input-group mb-3 d-none" id="box-div">
          <input type="text" id="message" class="bg-light form-control border-0 shadow-none" placeholder="Escribe un mensaje"
            aria-label="Enviar mensaje" aria-describedby="basic-addon2">
          <button class="btn btn-primary shadow-none" id="send-message"><i class="bx bxs-send"></i></button>
        </div>
      </section>
    </div>
  </main>
</html>