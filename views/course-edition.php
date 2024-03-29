<!DOCTYPE html>
<html lang="<?= LANG ?>">
<head>
  <meta charset="<?= CHARSET ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $this->env("APP_NAME") ?></title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">

  <?= $this->link("styles/pages/course-edition.css") ?>
  <?= $this->script("javascript/course-edition.js") ?>
</head>
<body>
  <?= $this->render("partials/navbar") ?>

  <!-- Main section -->
  <section class="container my-4">
    <div class="row border-3 border-bottom border-primary text-center mb-3">
      <h1>Editar curso</h1>
    </div>
    <form action="#" class="row" id="update-course-form">
      <div class="row mx-0">
        <div class="col-md-6 col-sm-12 col-xs-12">

          <input type="hidden" name="courseId" value="<?= $this->course["id"] ?>">

          <div class="mb-4">
            <label for="update-course-title" class="form-label" role="button">Título</label>
            <input type="text" name="title" id="update-course-title" 
              class="form-control" value="<?= $this->course["title"] ?>">
          </div>

          <div class="mb-4">
            <label for="update-course-description" class="form-label" role="button">Descripción</label>
            <textarea name="description" id="update-course-description" 
            cols="30" rows="3" class="form-control"><?= $this->course["description"] ?></textarea>
          </div>

          <div class="form-check">
            <input class="form-check-input shadow-none" type="checkbox" value="" 
            id="free-course-checkbox" autocomplete="off" disabled
            <?= ($this->course["price"] <= 0.0) ? "checked" : "" ?>>
            <label class="form-check-label" for="free-course-checkbox" role="button">El curso será gratis</label>
          </div>

          <div class="mb-4" id="price-group">
            <label class="form-label pt-2" for="price" role="button">Precio</label>
            <div class="input-group">
              <span class="input-group-text border-0 bg-light pe-0">$</span>
              <input type="number" name="price" id="update-course-price" 
              class="form-control" min="0.00" max="10000.00" step="0.01" 
              value="<?= $this->course["price"] ?>">
            </div>
          </div>

          <div class="mb-3">
            <label for="categories" class="form-label" role="button">Categorías</label>
            <select class="" id="categories" name="categories[]" multiple="multiple" placeholder="Seleccionar">
              <?php foreach ($this->categories as $category) : ?>
                <option value="<?= $category["id"] ?>"
                  <?= in_array($category["id"], $this->course["categories"]) ? "selected" : ""  ?>>
                  <?= $category["name"] ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>
          

        </div>

        <div class="center col-md-6 col-sm-12 col-xs-12 image-container">
          <label class="form-label">Portada</label>
          <label for="upload-image" class="rounded-3 ratio ratio-16x9 text-center img-area" role="button">
            <div class="d-flex justify-content-center align-items-center">
              <div>
                <i class="bx bxs-cloud-upload icon"></i>
                <h3>Subir imagen</h3>
              </div>
            </div>
            <img src="/api/v1/images/<?= $this->course["imageId"] ?>" alt=" " class="img-fluid rounded-3" id="picture-box">
            <input id="upload-image" type="file" accept="image/png, image/gif, image/jpeg, image/jpg" class="d-none form-control mt-3" autocomplete="off">
            <input type="hidden" name="course-cover" id="course-cover-id" class="d-none" autocomplete="off" value="<?= $this->course["imageId"] ?>">
          </label>
          <div id="image-error"></div>
        </div>

      </div>

     
      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary rounded-pill">
          Editar curso
        </button>
      </div>
    </form>

    <!-- Modal añadir nivel-->
    <div class="modal fade" id="create-level-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form class="modal-dialog rounded-1 border-0 shadow-none" id="create-level-form">
        <div class="modal-content rounded-1 border-0 shadow-sm">
          <div class="modal-header">
            <h4>Añadir nivel</h4>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-4">
              <label for="level-name" class="form-label" role="button">Título</label>
              <input type="text" name="title" id="create-level-title" class="form-control">
            </div>

            <div class="mb-4">
              <label for="level-description" class="form-label" role="button">Descripción</label>
              <textarea name="description" id="create-level-description" cols="30" rows="5" class="form-control" placeholder="¿Qué van a aprender los estudiantes en esta sección?"></textarea>
            </div>

            <div class="form-check">
              <input class="form-check-input shadow-none" type="checkbox" value="" id="free-level-checkbox" autocomplete="off">
              <label class="form-check-label" for="free-level-checkbox">El nivel será gratis</label>
            </div>

            <div class="mb-4 " id="level-price-group">
              <label for="create-level-price" class="form-label" role="button">Precio</label>
              <div class="input-group">
                <span class="input-group-text border-0 bg-light pe-0">$</span>
                <input type="number" name="price" id="create-level-price" class="form-control" min="0.00" max="10000.00" step="0.01" value="0.00">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="close-btn" type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Close</button>
            <button id="save-btn" type="submit" class="btn btn-primary rounded-pill">Agregar nivel</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Modal editar nivel-->
    <div class="modal fade animate__animated animate__bounceInDown" id="update-level-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form class="modal-dialog rounded-1 border-0 shadow-none" id="update-level-form">
        <div class="modal-content rounded-1 border-0 shadow-sm">
          <div class="modal-header">
            <h4>Editar nivel</h4>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div class="mb-4">
              <label for="level-name" class="form-label" role="button">Título</label>
              <input type="text" name="title" id="edit-level-title" class="form-control">
            </div>

            <div class="mb-4">
              <label for="level-description" class="form-label" role="button">Descripción</label>
              <textarea name="description" id="edit-level-description" cols="30" rows="5" class="form-control" placeholder="¿Qué van a aprender los estudiantes en esta sección?"></textarea>
            </div>

            <div class="form-check">
              <input class="form-check-input shadow-none" type="checkbox" value="" id="free-edit-level-checkbox">
              <label class="form-check-label" for="free-lesson-checkbox">El nivel será gratis</label>
            </div>

            <div class="mb-4" id="edit-level-price-group">
              <label for="" class="form-label">Precio</label>
              <div class="input-group">
                <span class="input-group-text border-0 bg-light pe-0">$</span>
                <input type="number" name="price" id="edit-level-price" class="form-control" min="0.00" max="10000.00" step="0.01" value="0.00">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="edit-level-close-btn" type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Close</button>
            <button id="edit-level-save-btn" type="submit" class="btn btn-primary rounded-pill">Guardar
              cambios</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Modal añadir lección -->
    <div class="modal fade" id="create-lesson-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form class="modal-dialog modal-lg rounded-1 border-0 shadow-none" id="create-lesson-form">
        <div class="modal-content">
          <div class="modal-header">
            <h4>Añadir lección</h4>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <input type="hidden" name="level" id="create-lesson-level">

            <div class="mb-4">
              <label class="form-label" role="button">Título</label>
              <input type="text" name="title" id="create-lesson-title" class="form-control">
            </div>

            <div class="mb-4">
              <label for="" role="button">Información adicional</label>
              <textarea name="description" id="create-lesson-description" cols="30" rows="5" class="form-control"></textarea>
            </div>

            <h5>Recursos</h5>
            <input type="hidden" name="resource">

            <div class="mb-4">
              <label for="" role="button">Video</label>
              <input type="file" name="video" id="create-lesson-video" class="form-control" autocomplete="off" accept="video/mp4">
            </div>

            <div class="mb-4">
              <label for="" role="button">Imágen</label>
              <input type="file" name="image" id="create-lesson-image" class="form-control" autocomplete="off" accept="image/png, image/gif, image/jpeg, image/jpg">
            </div>

            <div class="mb-4">
              <label for="" role="button">PDF</label>
              <input type="file" name="pdf" id="create-lesson-pdf" class="form-control" autocomplete="off" accept="application/pdf">
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
            <button id="close-btn" type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Close</button>
            <button id="save-btn" type="submit" class="btn btn-primary rounded-pill">Agregar lección</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Modal editar lección -->
    <div class="modal fade" id="update-lesson-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form class="modal-dialog modal-lg rounded-1 border-0 shadow-none" id="update-lesson-form">
        <div class="modal-content">
          <div class="modal-header">
            <h4>Editar lección</h4>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div class="mb-4">
              <label class="form-label" role="button">Título</label>
              <input type="text" name="title" id="edit-lesson-title" class="form-control">
            </div>

            <div class="mb-4">
              <label for="" role="button">Información adicional</label>
              <textarea name="description" id="edit-lesson-description" cols="30" rows="5" class="form-control"></textarea>
            </div>

            <div class="mb-4">
              <label for="" role="button">Video</label>
              <input type="file" name="video" id="edit-lesson-video" class="form-control">
            </div>

            <div class="mb-4">
              <label for="" role="button">Imágen</label>
              <input type="file" name="image" id="edit-lesson-img" class="form-control">
            </div>

            <div class="mb-4">
              <label for="" role="button">PDF</label>
              <input type="file" name="pdf" id="edit-lesson-pdf" class="form-control">
            </div>

            <div class="mb-4">
              <label for="" class="form-label" role="button">Enlace</label>
              <div class="mb-4">
                <label for="" role="button">Título</label>
                <input type="text" name="link-title" id="edit-lesson-link-title" class="form-control" placeholder="Título descriptivo">
              </div>
              <div class="mb-4">
                <label for="" role="button">URL</label>
                <input type="url" name="link" id="edit-lesson-link" class="form-control" placeholder="https://example.com">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="edit-lesson-close-btn" type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Close</button>
            <button id="edit-lesson-save-btn" type="submit" class="btn btn-primary rounded-pill">Guardar
              cambios</button>
          </div>
        </div>
      </form>
    </div>

  </section>
  <?= $this->render("partials/footer") ?>
</body>
</html>