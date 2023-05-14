<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\CategoryModel;
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
        $userId = $request->getSession()->get("id");

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
        $userId = $request->getSession()->get("id");
        $categoryId = intval($request->getParams("id"));

        if ($categoryId === 0) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Identificador no válido"
            ]);
        }

        $category = CategoryModel::findById($categoryId);
        if (!$category) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "No se encontró la categoría"
            ]);
            return;
        }

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

    public function create(Request $request, Response $response): void {
        // Para crear una categoría tiene que estar autenticado un instructor
        $userId = $request->getSession()->get("id");
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

        try {
            $isCreated = $category->save();
            if (!$isCreated) {
                $response->setStatus(404)->json([
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
            return;
        }
    }

    public function update(Request $request, Response $response): void {
        $categoryId = intval($request->getParams("id"));
        [
            "name" => $name,
            "description" => $description
        ] = $request->getBody();

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

        try {
            $isUpdated = $category->save();
            /*
            if (!$isUpdated) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "La categoría no se pudo actualizar"
                ]);
                return;
            }
            */

            $response->json([
                "status" => true,
                "message" => "La categoría se actualizó éxitosamente",
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
    }

    public function approve(Request $request, Response $response): void {
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
        $userId = $request->getSession()->get("id");

        try {
            $category
            ->setApproved(true)
            ->setApprovedBy($userId);

        $result = $category->save();
            if (!$result) {
                $response->setStatus(404)->json([
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
            return;
        }

        $response->json([
            "status" => true,
            "message" => $userId
        ]);
        return;
    }

    public function deny(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));

        //Validar que la categoria exista
        $userId = $request->getSession()->get("id");

        $category = CategoryModel::findById($id);
        if (!$category) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Categoría no encontrada"
            ]);
            return;
        }

        try { 
            $category
                ->setApproved(false)
                ->setApprovedBy($userId);

            $result = $category->save();
            if (!$result) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => $userId
                ]);
                return;
            }

            $response->json([
                "status" => true,
                "id" => "La categoría fue rechazada"
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
            $result = $category->activate($id);
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
            $result = $category->deactivate($id);
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

    public function checkNameExists(Request $request, Response $response): void {
        [
            "id" => $id,
            "name" => $name
        ] = $request->getBody();
        
        $category = CategoryModel::findOneByName($name, $id ?? -1);
        $response->json(!boolval($category));
    }
}
