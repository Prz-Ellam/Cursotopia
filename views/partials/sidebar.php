<div class="col-auto collapse d-lg-block col-md-3 col-xl-2 px-sm-2 px-0 bg-primary">
  <div class="text-white">
    <ul class="nav nav-pills flex-column mb-auto nav-list sidebar">
      <li class="nav-item">
        <a href="/profile?id=<?= $this->session("id") ?>" class="nav-link text-white" aria-current="page">
          <i class="bx bxs-home"></i>
          Inicio
        </a>
      </li>
      <li>
        <a href="/admin/courses" class="nav-link text-white">
          <i class='bx bxs-videos'></i>
          Cursos
        </a>
      </li>
      <li>
        <a href="/admin/categories" 
          class="nav-link text-white <?= ($this->selected == "categories") ? "active" : "" ?>">
          <i class="bx bxs-category"></i>
          Categorias
        </a>
      </li>
      <li>
        <a href="/blocked-users" class="nav-link text-white">
          <i class="bx bxs-group"></i>
          Usuarios
        </a>
      </li>
    </ul>
  </div>
</div>