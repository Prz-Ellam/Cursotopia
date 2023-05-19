<?php
  use Cursotopia\Helpers\Format;
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
  <meta charset="<?= CHARSET ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $this->env("APP_NAME") ?></title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">

  <?= $this->link("styles/pages/create-course.css") ?>
  <?= $this->script("javascript/course-create.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>

  <!-- Contenido -->
  <section class="container my-4 mb-3">
    
    <div class="border-3 border-bottom border-primary text-center mb-3">
      <h1>Añadir curso</h1>
    </div>
    <ul id="progressbar">
      <li class="active" id="basic-info">
        <p class="text-center fw-bold">Información básica</p>
      </li>
      <li id="course-content">
        <p class="text-center fw-bold">Contenido del curso</p>
      </li>
      <li id="confirm">
        <p class="text-center fw-bold">Publicar</p>
      </li>
    </ul>

    <!-- Crear un curso --> 
    <fieldset class="row mx-0" id="course-section">
      <form action="" class="row" id="course-create-form">
        <div class="col-md-6 col-sm-12">
          <input type="hidden" name="courseId" id="course-id">

          <div class="mb-4">
            <label for="title" class="form-label" role="button">Título</label>
            <input type="text" class="form-control" id="title" name="title">
          </div>

          <div class="mb-4">
            <label for="description" class="form-label" role="button">Descripción</label>
            <textarea class="form-control" id="description" cols="30" rows="3" 
              name="description" value="" placeholder="¿De que va a tratar tú curso?"></textarea>
          </div>

          <div class="form-check">
            <input class="form-check-input shadow-none" type="checkbox" value="" id="free-course-checkbox" autocomplete="off">
            <label class="form-check-label" for="free-course-checkbox" role="button">
              El curso será gratis
            </label>
          </div>

          <div class="mb-4" id="">
            <label class="form-label pt-2" for="price" role="button">Precio</label>
            <div class="input-group">
              <span class="input-group-text border-0 bg-light pe-0">$</span>
              <input type="number" name="price" id="price" class="form-control" autocomplete="off" min="0.01" max="10000.00" step="0.01" value="0.01">
            </div>
          </div>

          <div class="">
            <label class="form-label" role="button">Categorías</label>
            <select class="" id="categories" name="categories[]" multiple="multiple" placeholder="Seleccionar">
              <?php foreach ($this->categories as $category): ?>
                <option value="<?= $category["id"] ?>">
                  <?= $category["name"] ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>

          <div class="mt-4 col-sm-4 col-xs-4 col-md-5 col-xl-4">
            <button type="button" id="add-category-btn" class="btn btn-secondary rounded-pill btn-sm m-auto" data-bs-toggle="modal" data-bs-target="#category-create-modal">
              Añadir categoria
            </button>
          </div>
        </div>
        <div class="col-md-6 col-sm-12 image-container">
          <label class="form-label">Portada</label>
          <label for="upload-image" class="rounded-3 ratio ratio-16x9 text-center img-area" role="button">
            <div class="d-flex justify-content-center align-items-center">
              <div>
                <i class="bx bxs-cloud-upload icon"></i>
                <h3>Subir imagen</h3>
              </div>
            </div>
            <img src="" alt="" class="img-fluid rounded-3" id="picture-box">
            <input id="upload-image" name="image" type="file" accept="image/png, image/jpeg, image/jpg" class="d-none form-control mt-3" autocomplete="off">
            <input type="hidden" name="course-cover" id="course-cover-id" class="d-none" autocomplete="off">
          </label>
          <div id="image-error"></div>
        </div>
        
        <div class="d-grid mt-5 mb-5">
          <button type="submit" id="course-create-btn" 
            class="next btn btn-primary rounded-pill">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="course-create-spinner"></span>
            <span>Avanzar</span>
          </button>
        </div>
      </form>
    </fieldset>

    <fieldset class="my-5" id="levels-section">
      <div class="py-2 d-flex">
        <h4 class="pe-4">Niveles</h4>
        <button id="create-level-btn" type="button" class="btn btn-secondary rounded-pill btn-sm">
          Añadir nivel
        </button>
      </div>
      <ul class="list-unstyled" id="levels-container"></ul>

      <div class="row mt-5 mb-5">
        <button class="btn btn-primary rounded-pill col-6" id="course-back-btn">
          Anterior
        </button>
        <button type="button" id="confirm-course-btn" 
        class="next btn btn-primary rounded-pill col-6">Finalizar</button>
      </div>
    </fieldset>
  </section>

  <!-- Modal añadir nivel-->
  <div class="modal fade" id="level-create-modal" tabindex="-1" aria-labelledby="Crear nivel" aria-hidden="true">
    <form class="modal-dialog rounded-1 border-0 shadow-none" id="level-create-form">
      <div class="modal-content rounded-1 border-0 shadow-sm">
        <header class="modal-header">
          <h4>Añadir nivel</h4>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </header>
        <div class="modal-body">
          <input type="hidden" name="courseId" id="create-level-course-id">
          <div class="mb-4">
            <label for="level-name" class="form-label" role="button">Título</label>
            <input type="text" name="title" id="create-level-title" class="form-control">
          </div>
          <div class="mb-4">
            <label for="level-description" class="form-label" role="button">Descripción</label>
            <textarea name="description" id="create-level-description" cols="30" rows="5" class="form-control" placeholder="¿Qué van a aprender los estudiantes en esta sección?"></textarea>
          </div>
          <div class="form-check">
            <input class="form-check-input shadow-none" type="checkbox" value="" id="level-create-free" name="free" autocomplete="off">
            <label class="form-check-label" for="level-create-free">El nivel será gratis</label>
          </div>
        </div>
        <footer class="modal-footer">
          <button id="close-btn" type="button" class="btn btn-gray rounded-pill" data-bs-dismiss="modal">
            Cerrar
          </button>
          <button id="create-level-btn" type="submit" class="btn btn-primary rounded-pill">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="create-level-spinner"></span>
            Agregar nivel
          </button>
        </footer>
      </div>
    </form>
  </div>

  <!-- Modal editar nivel-->
  <div class="modal fade" id="level-update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class="modal-dialog rounded-1 border-0 shadow-none" id="update-level-form">
      <div class="modal-content rounded-1 border-0 shadow-sm">
        <div class="modal-header">
          <h4>Editar nivel</h4>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <input type="hidden" name="id" id="level-update-id">

          <div class="mb-4">
            <label for="level-name" class="form-label" role="button">Título</label>
            <input type="text" name="title" id="level-update-title" class="form-control">
          </div>

          <div class="mb-4">
            <label for="level-description" class="form-label" role="button">Descripción</label>
            <textarea name="description" id="level-update-description" cols="30" rows="5" class="form-control" placeholder="¿Qué van a aprender los estudiantes en esta sección?"></textarea>
          </div>

          <div class="form-check">
            <input class="form-check-input shadow-none" type="checkbox" value="" id="level-update-free">
            <label class="form-check-label" for="level-update-free">El nivel será gratis</label>
          </div>
        </div>
        <div class="modal-footer">
          <button id="edit-level-close-btn" type="button" class="btn btn-gray rounded-pill" data-bs-dismiss="modal">
            Cerrar
          </button>
          <button id="update-level-btn" type="submit" class="btn btn-primary rounded-pill">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="update-level-spinner"></span>
            Guardar cambios
          </button>
        </div>
      </div>
    </form>
  </div>

  <!-- Modal añadir lección -->
  <div class="modal fade" id="lesson-create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class="modal-dialog modal-lg rounded-1 border-0 shadow-none" id="create-lesson-form">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Añadir lección</h4>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <input type="hidden" name="levelId" id="create-lesson-level">

          <div class="mb-4">
            <label class="form-label" role="button">Título</label>
            <input type="text" name="title" id="create-lesson-title" class="form-control">
          </div>

          <div class="mb-4">
            <label for="" role="button">Información adicional</label>
            <textarea name="description" id="create-lesson-description" cols="30" rows="5" class="form-control"></textarea>
          </div>

          <h5>Recursos</h5>

          <div>
            <input type="hidden" name="resource">
          </div>

          <div class="mb-4">
            <label for="" role="button">Video</label>
            <input type="file" name="video" id="create-lesson-video" class="form-control" autocomplete="off" accept="video/mp4">
          </div>

          <div class="mb-4">
            <label for="" role="button">Imagen</label>
            <input type="file" name="image" id="create-lesson-image" class="form-control" autocomplete="off" accept="image/png, image/gif, image/jpeg, image/jpg">
          </div>

          <div class="mb-4">
            <label for="" role="button">PDF</label>
            <input type="file" name="document" id="create-lesson-pdf" class="form-control" autocomplete="off" accept="application/pdf">
          </div>

          <div class="mb-4">
            <label for="" class="form-label" role="button">Enlace</label>
            <div class="mb-4">
              <label for="" role="button">Título</label>
              <input type="text" name="link-title" id="create-lesson-link-title" class="form-control" placeholder="Título descriptivo">
            </div>
            <div class="mb-4">
              <label for="" role="button">URL</label>
              <input type="url" name="link-url" id="create-lesson-link-url" class="form-control" placeholder="https://example.com">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="close-btn" type="button" class="btn btn-gray rounded-pill" data-bs-dismiss="modal">
            Cerrar
          </button>
          <button id="create-lesson-btn" type="submit" class="btn btn-primary rounded-pill">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="create-lesson-spinner"></span>
            Agregar lección
          </button>
        </div>
      </div>
    </form>
  </div>

  <!-- Modal editar lección -->
  <div class="modal fade" id="lesson-update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class="modal-dialog modal-lg rounded-1 border-0 shadow-none" id="update-lesson-form">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Editar lección</h4>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <input type="hidden" name="id" id="lesson-update-id">

          <div class="mb-4">
            <label class="form-label" role="button">Título</label>
            <input type="text" name="title" id="edit-lesson-title" class="form-control">
          </div>

          <div class="mb-4">
            <label for="" role="button">Información adicional</label>
            <textarea name="description" id="edit-lesson-description" cols="30" rows="5" class="form-control"></textarea>
          </div>

          <div class="mb-4">
            <label for="" role="button">Video (dejar vacío para mantener el video anterior)</label>
            <div class="btn-group">
              <input type="file" name="video" id="update-lesson-video" class="form-control" accept="video/mp4">
              <button id="delete-video-btn" type="button" class="btn btn-danger rounded-end">Eliminar</button>
            </div>
          </div>

          <div class="mb-4">
            <label for="" role="button">Imagen (dejar vacío para mantener la imagen anterior)</label>
            <div class="btn-group">
              <input type="file" name="image" id="update-lesson-image" class="form-control" accept="image/png, image/gif, image/jpeg, image/jpg">
              <button id="delete-image-btn" type="button" class="btn btn-danger rounded-end">Eliminar</button>
            </div>
          </div>

          <div class="mb-4">
            <label for="" role="button">PDF (dejar vacío para mantener el documento anterior)</label>
            <div class="btn-group">
              <input type="file" name="document" id="update-lesson-document" class="form-control" accept="application/pdf">
              <button id="delete-document-btn" type="button" class="btn btn-danger rounded-end">Eliminar</button>
            </div>
          </div>

          <div class="mb-4">
            <label for="" class="form-label" role="button">Enlace</label>
            <div class="mb-4">
              <label for="" role="button">Título</label>
              <input type="text" name="link-title" id="edit-lesson-link-title" class="form-control" placeholder="Título descriptivo">
            </div>
            <div class="mb-4">
              <label for="" role="button">URL</label>
              <input type="url" name="link" id="edit-lesson-link-address" class="form-control" placeholder="https://example.com">
            </div>

            <button type="button" class="btn btn-danger rounded-pill" id="delete-link-btn">Eliminar</button>
            <button type="button" class="btn btn-primary rounded-pill" id="update-link-btn">Actualizar</button>
          </div>
        </div>
        <div class="modal-footer">
          <button id="edit-lesson-close-btn" type="button" class="btn btn-gray rounded-pill" data-bs-dismiss="modal">
            Cerrar
          </button>
          <button id="update-lesson-btn" type="submit" class="btn btn-primary rounded-pill">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="update-lesson-spinner"></span>
            Guardar cambios
          </button>
        </div>
      </div>
    </form>
  </div>

  <!-- Modal añadir categoría -->
  <div class="modal fade" id="category-create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content rounded-1 border-0 shadow-sm" id="category-create-form">
        <div class="modal-header">
          <h4>Añadir categoría</h4>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-4">
            <label for="category-name" class="form-label" role="button">Nombre</label>
            <input type="text" class="form-control" id="category-name" name="name" autocomplete="off">
          </div>
          <div class="mb-4">
            <label for="category-description" class="form-label" role="button">Descripción</label>
            <textarea class="form-control" id="category-description" name="description" rows="5" placeholder="¿Qué clase de cursos contendrá?"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button id="close-btn" type="button" class="btn btn-gray rounded-pill" data-bs-dismiss="modal">
            Cerrar
          </button>
          <button id="category-create-btn" type="submit" class="btn btn-primary rounded-pill">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="category-create-spinner"></span>
            Agregar
          </button>
        </div>
      </form>
    </div>
  </div>

  <?= $this->render("partials/footer") ?>
</body>
</html>