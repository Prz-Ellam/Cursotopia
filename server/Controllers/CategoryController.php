<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Category;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Repositories\CategoryRepository;
use Exception;
use PDO;

class CategoryController {
    /**
     * Crea y guarda una categoría
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function create(Request $request, Response $response): void {
        // Para crear una categoría tiene que estar autenticado un instructor
        $session = $request->getSession();

        $id = $session->get("id");
        $body = $request->getBody();

        $category = new CategoryModel($body);
        $category->setCreatedBy($id);

        try {
            $result = $category->save();
            if (!$result) {
                $response
                    ->setStatus(404)
                    ->json([
                        "status" => false,
                        "message" => ""
                    ]);
                return;
            }

            $response
                ->json([
                    "status" => true,
                    "id" => $category->getId()
                ]);
        }
        catch (Exception $ex) {
            $response
                ->setStatus(500)
                ->json([
                    "status" => false,
                    "message" => "We have a problem"
                ]);
            return;
        }
        //$response->json($categoryRepository->findOne(2));
    }

    /**
     * Actualiza una categoría
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
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
                $response
                    ->setStatus(404)
                    ->json([
                        "status" => false,
                        "message" => ""
                    ]);
                return;
            }

            $response
                ->json([
                    "status" => true,
                    "id" => $category->getId()
                ]);
        }
        catch (Exception $exception) {
            $response
                ->setStatus(500)
                ->json([
                    "status" => false,
                    "message" => "We have a problem"
                ]);
            return;
        }
    }

    // Aprobar una categoría
    // Eliminar una categoría ?
}
