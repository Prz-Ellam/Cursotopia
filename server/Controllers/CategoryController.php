<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Models\UserModel;
use Exception;

class CategoryController {
    public function categories(Request $request, Response $response): void {
        $notApprovedCategories = CategoryModel::findNotApproved();
        $notActiveCategories = CategoryModel::findNotActive();
        $categories = CategoryModel::findAll();

        $response->render("admin-categories", [
            "categories" => $categories,
            "notApprovedCategories" => $notApprovedCategories,
            "notActiveCategories" => $notActiveCategories
        ]);
    }

    public function getAll(Request $request, Response $response): void {
        $userId = intval($request->getSession()->get("id"));

        $categories = CategoryModel::findAllWithUser($userId);

        $response->json([
            "status" => true,
            "categories" => $categories
        ]);
    }

    public function getApproved(Request $request, Response $response): void {
        $categories = CategoryModel::findAll();

        $response->json([
            "status" => true,
            "categories" => $categories
        ]);
    }

    public function getNotApproved(Request $request, Response $response): void {
        $categories = CategoryModel::findNotApproved();

        $response->json([
            "status" => true,
            "categories" => $categories
        ]);
    }

    // Deprecated
    public function getNotActive(Request $request, Response $response): void {
        $categories = CategoryModel::findNotActive();

        $response->json([
            "status" => true,
            "categories" => $categories
        ]);
    }

    public function getOne(Request $request, Response $response): void {
        $userId = intval($request->getSession()->get("id"));
        $categoryId = intval($request->getParams("id"));

        if (!Validate::uint($categoryId)) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Identificador no válido"
            ]);
            return;
        }

        $category = CategoryModel::findById($categoryId);
        if (!$category) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "No se encontró la categoría"
            ]);
            return;
        }

        // Solo el creador de la categoría puede ver las no aprobadas
        if (!$category->getApproved() && $category->getCreatedBy() != $userId) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "No se encontró la categoría"
            ]);
            return;
        }

        $response->json([
            "status" => true,
            "category" => $category
        ]);
    }

    /**
     * Crea una categoría
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response): void {
        try {
            $userId = intval($request->getSession()->get("id"));
            [
                "name" => $name,
                "description" => $description
            ] = $request->getBody();

            // Validar que el nombre de la categoria no se repita

            $existingCategoryName = CategoryModel::findOneByName($name);
            if ($existingCategoryName) {
                $response->setStatus(409)->json([
                    "status" => false,
                    "message" => "Esta categoría ya fue creada o está en solicitud de serlo"
                ]);
                return;
            }

            $category = new CategoryModel([
                "name" => $name,
                "description" => $description,
                "createdBy" => $userId
            ]);

            $isCreated = $category->save();
            if (!$isCreated) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "La categoría no se pudo crear"
                ]);
                return;
            }

            $response->json([
                "status" => true,
                "message" => "La categoría se creó éxitosamente",
                "id" => $category->getId()
            ]);
        }
        catch (Exception $ex) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "We have a problem"
            ]);
        }
    }

    /**
     * Actualiza una categoría
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function update(Request $request, Response $response): void {
        try {
            $categoryId = intval($request->getParams("id"));
            [
                "name" => $name,
                "description" => $description
            ] = $request->getBody();

            if (!Validate::uint($categoryId)) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Identificador no válido"
                ]);
                return;
            }

            $category = CategoryModel::findById($categoryId);
            if (!$category) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Categoría no encontrada"
                ]);
                return;
            }

            $existingCategoryName = CategoryModel::findOneByName($name, $categoryId);
            if ($existingCategoryName) {
                $response->setStatus(409)->json([
                    "status" => false,
                    "message" => "Ya existe una categoría con ese nombre"
                ]);
                return;
            }

            $category
                ->setName($name)
                ->setDescription($description);

            $isUpdated = $category->save();

            $response->json([
                "status" => true,
                "message" => "La categoría se actualizó éxitosamente",
                "id" => $category->getId()
            ]);
        }
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "Ocurrio un error en el servidor"
            ]);
        }
    }

    /**
     * Aprueba una categoría
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function approve(Request $request, Response $response): void {
        try {
            $categoryId = intval($request->getParams("id"));
            $userId = intval($request->getSession()->get("id"));
            if (!Validate::uint($categoryId)) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Identificador no válido"
                ]);
                return;
            }

            $category = CategoryModel::findById($categoryId);
            if (!$category) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Categoría no encontrada"
                ]);
                return;
            }

            $user = UserModel::findById($userId);
            if (!$user) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Usuario no encontrado"
                ]);
                return;
            }

            if ($category->getApprovedBy()) {
                $response->setStatus(409)->json([
                    "status" => false,
                    "message" => "La categoría ya fue aprobada o rechazada"
                ]);
                return;
            }

            $category
                ->setApproved(true)
                ->setApprovedBy($userId);

            $isUpdated = $category->save();
            if (!$isUpdated) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "No se pudo aprobar la categoría"
                ]);
                return;
            }

            $response->json([
                "status" => true,
                "message" => "La categoría se aprobó éxitosamente" 
            ]);
        }
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "We have a problem"
            ]);
        }
    }

    /**
     * Rechaza una categoría
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function deny(Request $request, Response $response): void {
        try { 
            $categoryId = intval($request->getParams("id"));
            $userId = $request->getSession()->get("id");
            if (!Validate::uint($categoryId)) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Identificador no válido"
                ]);
                return;
            }

            $category = CategoryModel::findById($categoryId);
            if (!$category) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Categoría no encontrada"
                ]);
                return;
            }

            $user = UserModel::findById($userId);
            if (!$user) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Usuario no encontrado"
                ]);
                return;
            }

            if ($category->getApprovedBy()) {
                $response->setStatus(409)->json([
                    "status" => false,
                    "message" => "La categoría ya fue aprobada o rechazada"
                ]);
                return;
            }

            $category
                ->setApproved(false)
                ->setApprovedBy($userId);

            $isUpdated = $category->save();
            if (!$isUpdated) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "No se pudo rechazar la categoría"
                ]);
                return;
            }

            $response->json([
                "status" => true,
                "message" => "La categoría fue rechazada"
            ]);
        }
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "Ocurrio un error en el servidor"
            ]);
        }
    }

    // Deprecated !!
    public function activate(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));

        //Validar que la categoria exista

        $category = CategoryModel::findById($id);
        if (!$category) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Categoría no encontrada"
            ]);
            return;
        }

        //Validar que el usuario sea administrador
        $session = $request->getSession();
        $userId = $session->get("id");
        $role = $session->get("role");

        if ($role != 1) {
            $response->json([
                "status" => false,
                "message" => "Solo los administradores pueden activar categorias"
            ]);
            return;
        }

        try {
            //$result = $category->activate($id);
            $result = $category->setActive(true)->save();
            if (!$result) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => $userId
                ]);
                return;
            }

            $response->json([
                "status" => true,
                "id" => $category->getId()
            ]);
        }
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "We have a problem"
            ]);
            return;
        }

        $response->json([
            "status" => true,
            "message" => $userId
        ]);
        return;
    }

    // Deprecated !!
    public function deactivate(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));

        //Validar que la categoria exista

        $category = CategoryModel::findById($id);
        if (!$category) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Categoría no encontrada"
            ]);
            return;
        }

        //Validar que el usuario sea administrador
        $session = $request->getSession();
        $userId = $session->get("id");
        $role = $session->get("role");

        if ($role != 1) {
            $response->json([
                "status" => false,
                "message" => "Solo los administradores pueden activar categorias"
            ]);
            return;
        }

        try {
            $result = $category->setActive(false)->save();
            if (!$result) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => $userId
                ]);
                return;
            }

            $response->json([
                "status" => true,
                "id" => $category->getId()
            ]);
        }
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "We have a problem"
            ]);
            return;
        }

        $response->json([
            "status" => true,
            "message" => $userId
        ]);
        return;
    }

    /**
     * Busca si una categoría existe basado en su nombre
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function checkNameExists(Request $request, Response $response): void {
        [
            "id" => $id,
            "name" => $name
        ] = $request->getBody();

        if (!Validate::uint($id)) {
            $id = null;
        }

        if (!Validate::maxlength($name, 50)) {
            $name = null;
        }
        
        $category = CategoryModel::findOneByName($name, $id ?? -1);
        $response->json(!boolval($category));
    }
}
