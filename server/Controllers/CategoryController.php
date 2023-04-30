<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Repositories\CategoryRepository;
use Exception;

class CategoryController {
    public function categories(Request $request, Response $response): void {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findNotApproved();

        $response->render("admin-categories", [
            "categories" => $categories
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

    public function create(Request $request, Response $response): void {
        // Para crear una categoría tiene que estar autenticado un instructor
        $session = $request->getSession();
        // /^[A-Za-z0-9\s\-_,\.;:()]+$/
        $id = $session->get("id");
        $body = $request->getBody();

        [
            "name" => $name,
            "description" => $description
        ] = $request->getBody();

        // Validar que el nombre de la categoria no se repita
        /*
            $existingCategoryName = Category::findByName($name);
            if ($existingCategoryName) {
                $response->json([
                    "status" => false,
                    "message" => "Ya existe una categoría con ese nombre"
                ]);
                return;
            }
        */

        // Validar que el usuario es un instructor

        $category = new CategoryModel($body);
        $category->setCreatedBy($id);

        try {
            $result = $category->save();
            if (!$result) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => ""
                ]);
                return;
            }

            $response->json([
                "status" => true,
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
        //$response->json($categoryRepository->findOne(2));
    }

    public function update(Request $request, Response $response): void {
        // Solo los administradores pueden editar categorías
        // Este es el id de la categoría
        $id = $request->getParams("id");

        $category = CategoryModel::findOneById($id);
        $category
            ->setName($request->getBody("name"))
            ->setDescription($request->getBody("description"));

        try {
            $result = $category->save();
            if (!$result) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => ""
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
    }

    public function delete(Request $request, Response $response): void {

    }

    public function approve(Request $request, Response $response): void {
        
    }
}
