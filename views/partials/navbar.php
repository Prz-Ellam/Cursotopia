<?php
use Cursotopia\Helpers\Auth;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Repositories\ChatMessageRepository;

$id = $_SESSION["id"] ?? null;

$categories = CategoryModel::findAll();
$unreadMessages = 0;
if ($id) {
  $chatMessageRepository = new ChatMessageRepository();
  $unreadMessages = $chatMessageRepository->getUnreadMessages($id);
  $unreadMessages = $unreadMessages["unread_messages"];
}
?>
<!-- Navbar de instructor --> 
<nav class="sticky-top navbar navbar-expand-lg bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="/home">
      <img 
        src="../client/assets/images/logo.png" 
        alt="Logo" 
        width="34" 
        height="34" 
        class="d-inline-block align-text-top"
      >
      <span class="align-middle">Cursotopia</span>
    </a>
    <button 
      class="border-0 shadow-none navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbar-content"
      aria-controls="navbar-content"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="text-white bx-sm bx bx-menu"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar-content">
      <form class="col-md-auto col-lg-5 col-xl-7" role="search" action="search" method="GET">
        <div class="input-group">
          <input
            class="form-control bg-white"
            type="search"
            placeholder="Buscar cursos..."
            name="title"
            aria-label="Search">
          <button class="btn btn-white border-0 text-dark search-btn" type="submit">
            <i class="fw-bold bx bx-search"></i>
          </button>
        </div>
      </form>
      <?php if (Auth::auth(1)): ?>
        <ul class="navbar-nav ms-auto d-lg-flex align-items-lg-center me-2">
          <li class="nav-item dropdown">
            <a
              class="nav-link fw-bold text-light dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Categorías
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php foreach ($categories as $category): ?>
              <li><a class="dropdown-item" href="search"><?= $category["name"] ?></a></li>
              <?php endforeach ?>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" aria-current="page" href="chat">
              <i class="bx-sm bx bxs-bell position-relative">
                <?php if ($unreadMessages > 0): ?>
                <span class="badge rounded-pill badge-notification bg-danger">
                  <?= ($unreadMessages < 9) ? $unreadMessages : "+9"  ?>
                </span>
                <?php endif ?>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <div class="nav-link dropdown">
              <button
                class="btn border-0 p-0"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <img 
                  src="/api/v1/images/<?= $_SESSION["profilePicture"] ?>"
                  alt="mdo"
                  width="32"
                  height="32"
                  class="rounded-circle profile-picture">
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item" href="profile?id=<?= $_SESSION["id"] ?>">Mi perfil</a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item" href="/api/v1/logout">Cerrar sesión</a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      <?php elseif (Auth::auth(2)): ?>
        <ul class="navbar-nav ms-auto d-lg-flex align-items-lg-center me-2">
          <li class="nav-item">
            <a href="course-creation" class="nav-link fw-bold text-light">
              Crear curso
            </a>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link fw-bold text-light dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Categorías
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php foreach ($categories as $category): ?>
              <li><a class="dropdown-item" href="search"><?= $category["name"] ?></a></li>
              <?php endforeach ?>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" aria-current="page" href="chat">
              <i class="bx-sm bx bxs-bell position-relative">
                <?php if ($unreadMessages > 0): ?>
                <span class="badge rounded-pill badge-notification bg-danger">
                  <?= ($unreadMessages < 9) ? $unreadMessages : "+9"  ?>
                </span>
                <?php endif ?>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <div class="nav-link dropdown">
              <button
                class="btn border-0 p-0"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <img 
                  src="/api/v1/images/<?= $_SESSION["profilePicture"] ?>"
                  alt="mdo"
                  width="32"
                  height="32"
                  class="rounded-circle profile-picture">
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item" href="profile?id=<?= $_SESSION["id"] ?>">Mi perfil</a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item" href="/api/v1/logout">Cerrar sesión</a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      <?php elseif (Auth::auth(3)): ?>
        <ul class="navbar-nav ms-auto d-lg-flex align-items-lg-center me-2">
          <li class="nav-item">
            <a href="profile?id=<?= $_SESSION["id"] ?>" class="nav-link fw-bold text-light">
              Mis cursos
            </a>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link fw-bold text-light dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Categorías
            </a>
            <ul class="dropdown-menu">
              <?php foreach ($categories as $category): ?>
              <li><a class="dropdown-item" href="search"><?= $category["name"] ?></a></li>
              <?php endforeach ?>
            </ul>
          </li>    
          <li class="nav-item">
            <a class="nav-link text-light" aria-current="page" href="chat">
              <i class="bx-sm bx bxs-bell position-relative">
                <?php if ($unreadMessages > 0): ?>
                <span class="badge rounded-pill badge-notification bg-danger">
                  <?= ($unreadMessages < 9) ? $unreadMessages : "+9"  ?>
                </span>
                <?php endif ?>
              </i>
            </a>
          </li>
          <li class="nav-item">
            <div class="nav-link dropdown">
              <button
                class="btn border-0 p-0"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <img 
                  src="/api/v1/images/<?= $_SESSION["profilePicture"] ?>"
                  alt="mdo"
                  width="32"
                  height="32"
                  class="rounded-circle profile-picture">
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item" href="profile?id=<?= $_SESSION["id"] ?>">Mi perfil</a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item" href="/api/v1/logout">Cerrar sesión</a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      <?php else: ?>
        <ul class="navbar-nav ms-auto d-lg-flex align-items-lg-center me-2">
          <li class="nav-item dropdown">
            <a
              class="nav-link fw-bold text-light dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Categorías
            </a>
            <ul class="dropdown-menu">
              <?php foreach ($categories as $category): ?>
              <li><a class="dropdown-item" href="search"><?= $category["name"] ?></a></li>
              <?php endforeach ?>
            </ul>
          </li>
          <li class="nav-item">
            <a href="signup" class="nav-link fw-bold text-light d-flex align-items-center">
              <i class='bx-sm bx bxs-user-plus'></i>Registrarse
            </a>
          </li>
          <li class="nav-item">
            <a href="login" class="nav-link fw-bold text-light d-flex align-items-center">
              <i class='bx-sm bx bxs-user-check' ></i>Iniciar sesión
            </a>
          </li>
        </ul>
      <?php endif ?>
    </div>
  </div>
</nav>