<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Repositories\CategoryRepository;
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
        $session = $request->getSession();
        $id = $session->get("id");

        $categories = CategoryModel::findAllWithUser($id);

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

    public function getNotActive(Request $request, Response $response): void {

        $categories = CategoryModel::findNotActive();

        $response->json([
            "status" => true,
            "categories" => $categories
        ]);
    }

    public function findById(Request $request, Response $response): void {
        $session = $request->getSession();
        $id = $session->get("id");

        $categoryId = $request->getParams("id");

        $category = CategoryModel::findById($categoryId);

        if (!$category) {
            $response->setStatus(404)->json([
                "status" => true,
                "category" => "No se encontró la categoria"
            ]);
        }

        $response->json([
            "status" => true,
            "category" => $category
        ]);
    }

    public function create(Request $request, Response $response): void {
        // Para crear una categoría tiene que estar autenticado un instructor
        $session = $request->getSession();
        
        $id = $session->get("id");
        $role = $session->get("role");
        $body = $request->getBody();

        [
            "name" => $name,
            "description" => $description
        ] = $request->getBody();

        // Validar que el nombre de la categoria no se repita

        $existingCategoryName = CategoryModel::findOneByName($name);
        if ($existingCategoryName) {
            $response->setStatus(409)->json([
                "status" => false,
                "message" => "Ya existe una categoría con ese nombre"
            ]);
            return;
        }

        // Validar que el usuario es un instructor

        $category = new CategoryModel($body);
        $category->setCreatedBy($id);

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

        $category = CategoryModel::findCategoryById($categoryId);
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

    public function delete(Request $request, Response $response): void {

    }

    public function approve(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));

        //Validar que la categoria exista

        $category = CategoryModel::findCategoryById($id);
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
                "message" => "Solo los administradores pueden aprobar categorias"
            ]);
            return;
        }

        try {
            $result = $category->approve($userId, $id);
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

    public function deny(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));

        //Validar que la categoria exista

        $category = CategoryModel::findCategoryById($id);
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

        if ($role!=1) {
            $response->json([
                "status" => false,
                "message" => "Solo los administradores pueden denegar categorias"
            ]);
            return;
        }

        try {
            $result = $category->deny($id);
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

    public function activate(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));

        //Validar que la categoria exista

        $category = CategoryModel::findCategoryById($id);
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

        $category = CategoryModel::findCategoryById($id);
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
        
        $categoryRepository = new CategoryRepository();
        $category = $categoryRepository->findOneByName($name, $id ?? -1);

        $response->json(!boolval($category));
    }
}
