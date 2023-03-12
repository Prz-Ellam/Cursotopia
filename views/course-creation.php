<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $_ENV["APP_NAME"] ?></title>

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto&display=swap" rel="stylesheet">

	<script defer src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

	<!-- Boxicons -->
	<link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">

	<!-- SweetAlert -->
	<link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">

	<link rel="stylesheet" href="../client/styles/pages/create-course.css">
	<script defer type="module" src="../dist/javascript/course-creation.js"></script>
</head>

<body>
	<?= $this->render("partials/navbar") ?>

	<!-- Contenido -->
	<section class="container my-4 mb-3">
		<div class="row border-3 border-bottom border-primary text-center mb-3">
			<h1>Añadir curso</h1>
		</div>
		<form action="#" class="row" id="create-course-form">
			<div class="row mx-0">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="mb-4">
						<label for="title" class="form-label" role="button">Título</label>
						<input type="text" class="form-control" id="title" name="title">
					</div>
					<div class="mb-4">
						<label for="description" class="form-label" role="button">Descripción</label>
						<textarea class="form-control" id="description" cols="30" rows="3" name="description"></textarea>
					</div>
					<div class="form-check">
						<input class="form-check-input shadow-none" type="checkbox" value="" id="free-course-checkbox"
							autocomplete="off">
						<label class="form-check-label" for="free-course-checkbox" role="button">El curso será gratis</label>
					</div>
					<div class="mb-4" id="price-group">
						<label class="form-label pt-2" for="price" role="button">Precio</label>
						<div class="input-group">
							<span class="input-group-text border-0 bg-light pe-0">$</span>
							<input type="number" name="price" id="price" class="form-control" autocomplete="off" min="0.00" max="10000.00" step="0.01" value="0.00">
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label" role="button">Categorías</label>
						<select class="" id="categories" name="categories[]" multiple="multiple" placeholder="Seleccionar">
							<?php foreach($this->categories as $category): ?>
							<option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-sm-4 col-xs-4 col-md-5 col-xl-4">
						<button type="button" id="add-category-btn" class="btn btn-secondary rounded-pill btn-sm m-auto"
							data-bs-toggle="modal" data-bs-target="#create-category-modal">Añadir categoria</button>
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
						<img src="" alt=" " class="img-fluid rounded-3" id="picture-box">
						<input id="upload-image" type="file" accept="image/png, image/gif, image/jpeg, image/jpg"
							class="d-none form-control mt-3" autocomplete="off">
					</label>
					<input type="text" name="course-cover" id="course-cover-id" class="d-none" autocomplete="off">
				</div>
			</div>

			<div id="levels-list">
				<input type="hidden" name="levels[]" autocomplete="off">
			</div>

			<section class="my-5" id="levels-section">
				<div class="py-2 d-flex">
					<h4 class="pe-4">Niveles</h4>
					<button id="create-level-btn" type="button" class="btn btn-secondary rounded-pill btn-sm">
						Añadir nivel
					</button>
				</div>
				<ul class="list-unstyled" id="levels-container">

				</ul>
				<!--
				<div class="border-0 card shadow-none">
					<div class="rounded-top bg-light card-header">
						<div class="row align-items-center">
							<div class="col-9">
								<label for="">Nivel 1: Introducción</label>
							</div>
							<div class="col-3 text-lg-end text-center">
								<button type="button" class="btn btn-sm btn-secondary rounded-pill" data-bs-toggle="modal"
									data-bs-target="#add-lesson">Añadir lección</button>
								<span class="d-lg-inline d-block text-lg-end text-center">
									<a id="edit-level-btn" href="#" class="btn text-success border-0 m-auto p-1" data-bs-toggle="modal"
										data-bs-target="#editLevel"><i class='bx bxs-pencil'></i></a>
									<button type="button" class="btn text-danger border-0 m-auto p-1 delete-level-btn">
										<i class='bx bxs-trash-alt'></i>
									</button>
									<a class="btn text-primary border-0 m-auto p-1" href="#collapseExample1" data-bs-toggle="collapse"
										role="button" aria-expanded="false" aria-controls="collapseExample">
										<i class='bx bxs-chevron-down'></i>
									</a>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="collapse" id="collapseExample1">
					<ul class="list-group list-group-flush">
						<li class="list-group-item d-flex align-items-center justify-content-between">
							<span>Lección 1: Introducción al curso
							</span>
							<span>
								<a href="#" class="edit-lesson-btn btn text-success border-0 m-auto p-1" data-bs-toggle="modal"
									data-bs-target="#edit-lesson"><i class='bx bxs-pencil'></i></a>
								<button type="button" class="delete-lesson-btn btn text-danger border-0 m-auto p-1">
									<i class='bx bxs-trash-alt'></i>
								</button>
							</span>
						</li>
						<li class="list-group-item d-flex align-items-center justify-content-between">
							<span>Lección 1: Sobre Java
							</span>
							<span>
								<a href="#" class="edit-lesson-btn btn text-success border-0 m-auto p-1" data-bs-toggle="modal"
									data-bs-target="#edit-lesson"><i class='bx bxs-pencil'></i></a>
								<button type="button" class="delete-lesson-btn btn text-danger border-0 m-auto p-1"><i
										class='bx bxs-trash-alt'></i></button>
							</span>
						</li>
						<li class="list-group-item d-flex align-items-center justify-content-between">
							<span>Lección 3: Sobre POO
							</span>
							<span>
								<a href="#" class="edit-lesson-btn btn text-success border-0 m-auto p-1" data-bs-toggle="modal"
									data-bs-target="#edit-lesson"><i class='bx bxs-pencil'></i></a>
								<button type="button" class="delete-lesson-btn btn text-danger border-0 m-auto p-1"><i
										class='bx bxs-trash-alt'></i></button>
							</span>
						</li>
					</ul>
				</div>
				-->
			</section>
			<div class="d-flex mb-5">
				<button type="submit" class="btn btn-primary rounded-pill w-100">Crear curso</button>
			</div>
		</form>
	</section>

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
						<textarea name="description" id="create-level-description" cols="30" rows="5" class="form-control"
							placeholder="¿Qué van a aprender los estudiantes en esta sección?"></textarea>
					</div>

					<div class="form-check">
						<input class="form-check-input shadow-none" type="checkbox" value="" id="free-level-checkbox"
							autocomplete="off">
						<label class="form-check-label" for="free-level-checkbox">El nivel será gratis</label>
					</div>

					<div class="mb-4 " id="level-price-group">
						<label for="" class="form-label">Precio</label>
						<div class="input-group">
							<span class="input-group-text border-0 bg-light pe-0">$</span>
							<input type="number" name="price" id="level-price" class="form-control"  min="0.00" max="10000.00" step="0.01" value="0.00">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="close-btn" type="button" class="btn btn-danger rounded-pill"
						data-bs-dismiss="modal">Close</button>
					<button id="save-btn" type="submit" class="btn btn-primary rounded-pill">Agregar nivel</button>
				</div>
			</div>
		</form>
	</div>

	<!-- Modal editar nivel-->
	<div class="modal fade animate__animated animate__bounceInDown" id="update-level-modal" tabindex="-1"
		aria-labelledby="exampleModalLabel" aria-hidden="true">
		<form class="modal-dialog rounded-1 border-0 shadow-none" id="update-level-form">
			<div class="modal-content rounded-1 border-0 shadow-sm">
				<div class="modal-header">
					<h4>Editar nivel</h4>
					<button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">

					<input type="hidden" name="id" id="edit-level-id">

					<div class="mb-4">
						<label for="level-name" class="form-label" role="button">Título</label>
						<input type="text" name="title" id="edit-level-title" class="form-control">
					</div>

					<div class="mb-4">
						<label for="level-description" class="form-label" role="button">Descripción</label>
						<textarea name="description" id="edit-level-description" cols="30" rows="5" class="form-control"
							placeholder="¿Qué van a aprender los estudiantes en esta sección?"></textarea>
					</div>

					<div class="form-check">
						<input class="form-check-input shadow-none" type="checkbox" value="" id="free-edit-level-checkbox">
						<label class="form-check-label" for="free-lesson-checkbox">El nivel será gratis</label>
					</div>

					<div class="mb-4" id="edit-level-price-group">
						<label for="" class="form-label">Precio</label>
						<div class="input-group">
							<span class="input-group-text border-0 bg-light pe-0">$</span>
							<input type="number" name="price" id="edit-level-price" class="form-control"  min="0.00" max="10000.00" step="0.01" value="0.00">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="edit-level-close-btn" type="button" class="btn btn-danger rounded-pill"
						data-bs-dismiss="modal">Close</button>
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
						<textarea name="description" id="create-lesson-description" cols="30" rows="5"
							class="form-control"></textarea>
					</div>

					<h5>Recursos</h5>
					<input type="hidden" name="resource">

					<div class="mb-4">
						<label for="" role="button">Video</label>
						<input type="file" name="video" id="create-lesson-video" class="form-control" autocomplete="off"
							accept="video/mp4">
					</div>

					<div class="mb-4">
						<label for="" role="button">Imágen</label>
						<input type="file" name="image" id="create-lesson-image" class="form-control" autocomplete="off"
							accept="image/png, image/gif, image/jpeg, image/jpg">
					</div>

					<div class="mb-4">
						<label for="" role="button">PDF</label>
						<input type="file" name="pdf" id="create-lesson-pdf" class="form-control" autocomplete="off"
							accept="application/pdf">
					</div>

					<div class="mb-4">
						<label for="" class="form-label" role="button">Enlace</label>
						<div class="mb-4">
							<label for="" role="button">Título</label>
							<input type="text" name="link-title" id="create-lesson-link-title" class="form-control"
								placeholder="Título descriptivo">
						</div>
						<div class="mb-4">
							<label for="" role="button">URL</label>
							<input type="url" name="link-url" id="create-lesson-link-url" class="form-control"
								placeholder="https://example.com">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="close-btn" type="button" class="btn btn-danger rounded-pill"
						data-bs-dismiss="modal">Close</button>
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
						<textarea name="description" id="edit-lesson-description" cols="30" rows="5"
							class="form-control"></textarea>
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
							<input type="text" name="link-title" id="edit-lesson-link-title" class="form-control"
								placeholder="Título descriptivo">
						</div>
						<div class="mb-4">
							<label for="" role="button">URL</label>
							<input type="url" name="link" id="edit-lesson-link" class="form-control"
								placeholder="https://example.com">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="edit-lesson-close-btn" type="button" class="btn btn-danger rounded-pill"
						data-bs-dismiss="modal">Close</button>
					<button id="edit-lesson-save-btn" type="submit" class="btn btn-primary rounded-pill">Guardar
						cambios</button>
				</div>
			</div>
		</form>
	</div>

	<!-- Modal añadir categoría -->
	<div class="modal fade animate__animated animate__bounceInDown" id="create-category-modal" tabindex="-1"
		aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<form class="modal-content rounded-1 border-0 shadow-sm" id="create-category-form">
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
						<textarea class="form-control" id="category-description" name="description" rows="5"
							placeholder="¿Qué clase de cursos contendrá?"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button id="close-btn" type="button" class="btn btn-danger rounded-pill"
						data-bs-dismiss="modal">Cerrar</button>
					<button id="save-btn" type="submit" class="btn btn-primary rounded-pill">Agregar</button>
				</div>
			</form>
		</div>
	</div>

  <?= $this->render("partials/footer") ?>
</body>
</html>