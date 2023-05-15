<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\LessonModel;
use Cursotopia\Models\LinkModel;

class LinkController {
    public function getOne(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));
        if (!Validate::uint($id)) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Identificador no válido"
            ]);
            return;
        }

        $link = LinkModel::findById($id);
        if (!$link) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Enlace no encontrado"
            ]);
            return;
        }

        $response->json($link);
    }
    
    public function create(Request $request, Response $response, Closure $next): void {
        [
            "name" => $name,
            "address" => $address
        ] = $request->getBody();
        
        $link = new LinkModel([
            "name" => $name,
            "address" => $address
        ]);
        $link->save();

        $response->setStatus(201)->json([
            "status" => true,
            "message" => "En enlace se creó éxitosamente"
        ]);
    }

    public function update(Request $request, Response $response): void {
        $linkId = intval($request->getParams("id"));
        [
            "name" => $name,
            "address" => $address
        ] = $request->getBody();

        $link = LinkModel::findById($linkId);
        if (!$link) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Enlace no encontrado"
            ]);
            return;
        }

        $link
            ->setName($name)
            ->setAddress($address);

        $link->save();

        $response->json([
            "status" => true,
            "message" => "Enlace actualizado éxitosamente"
        ]);
    }

    public function putLessonLink(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $lessonId = $request->getParams("id");

        [
            "name" => $name,
            "address" => $address
        ] = $request->getBody();
        
        $lesson = LessonModel::findById($lessonId);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        $link = new LinkModel([
            "name" => $name,
            "address" => $address
        ]);

        $isCreated = $link->save();
        if (!$isCreated) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "No se pudo crear la imagen"
            ]);
            return;
        }

        $lesson->setLinkId($link->getId());
        $lesson->save();

        $response->json([
            "status" => true,
            "message" => "Enlace cargado",
            "id" => $link->getId()
        ]);
    }

    public function delete(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $linkId = $request->getParams("id");

        $link = LinkModel::findById($linkId);
        if (!$link) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Enlace no encontrado"
            ]);
            return;
        }

        $link
            ->setActive(false);

        $link->save();

        $response->json([
            "status" => true,
            "message" => "El enlace fue eliminado"
        ]);
    }
}
