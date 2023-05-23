<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\LessonModel;
use Cursotopia\Models\VideoModel;
use Cursotopia\Repositories\VideoRepository;
use DateTime;
use getID3;
use Ramsey\Uuid\Nonstandard\Uuid;

class VideoController {
    public function create(Request $request, Response $response, Closure $next): void {
        $file = $request->getFiles("video");
        if (!$file) {
            /*
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Faltan parametros"
            ]);
            */
            $payload = $request->getBody("payload");
            if ($payload) {
                $payloadObj = json_decode($payload, true);
                if ($payloadObj) {
                    $payloadObj["videoId"] = null;
                    $request->setBodyParam("payload", json_encode($payloadObj));
                }
            }
            $next();
            return;
        }

        $allowedExtensions = [ "video/mp4" ];
        if (!in_array($file->getType(), $allowedExtensions)) {
            $payload = $request->getBody("payload");
            if ($payload) {
                $payloadObj = json_decode($payload, true);
                if ($payloadObj) {
                    $payloadObj["videoId"] = null;
                    $request->setBodyParam("payload", json_encode($payloadObj));
                }
            }
            $next();
            return;
        }

        if ($file->getSize() > 1 * 1024 * 1024 * 1024) {
            $payload = $request->getBody("payload");
            if ($payload) {
                $payloadObj = json_decode($payload, true);
                if ($payloadObj) {
                    $payloadObj["videoId"] = null;
                    $request->setBodyParam("payload", json_encode($payloadObj));
                }
            }
            $next();
            return;
        }

        $getID3 = new getID3();
        $fileinfo = $getID3->analyze($file->getTmpName());

        $name = Uuid::uuid4()->toString();
        $ext = pathinfo($file->getName(), PATHINFO_EXTENSION);
        $contentType = $file->getType();
        $duration = round($fileinfo["playtime_seconds"]);
        
        $hours = floor($duration / 3600);
        $minutes = floor(($duration - ($hours * 3600)) / 60);
        $seconds = round($duration - ($hours * 3600) - ($minutes * 60));
        $time_string = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

        $address = UPLOADS_DIR . "/$name.$ext";
        
        move_uploaded_file($file->getTmpName(), $address);

        $video = new VideoModel([
            "name" => $name,
            "duration" => $time_string,
            "contentType" => $contentType,
            "address" => $address
        ]);
        $result = $video->save();
        $videoId = $video->getId();
        /*
        $response->json([
            "status" => true,
            "id" => $videoId,
            "message" => $rowsAffected
        ]);
        */
        $payload = $request->getBody("payload");
        if ($payload) {
            $payloadObj = json_decode($payload, true);
            if ($payloadObj) {
                $payloadObj["videoId"] = $videoId;
                $request->setBodyParam("payload", json_encode($payloadObj));
            }
        }

        $next();
    }

    public function update(Request $request, Response $response): void {
        $videoId = intval($request->getParams("id"));
        $file = $request->getFiles("video");
        if (!$file) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Faltan parametros"
            ]);
            return;
        }

        $getID3 = new getID3();
        $fileinfo = $getID3->analyze($file->getTmpName());

        $name = Uuid::uuid4()->toString();
        $ext = pathinfo($file->getName(), PATHINFO_EXTENSION);
        $contentType = $file->getType();
        $duration = round($fileinfo["playtime_seconds"]);
        
        $hours = floor($duration / 3600);
        $minutes = floor(($duration - ($hours * 3600)) / 60);
        $seconds = round($duration - ($hours * 3600) - ($minutes * 60));
        $time_string = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

        $address = UPLOADS_DIR . "/$name.$ext";
        
        move_uploaded_file($file->getTmpName(), $address);

        $video = VideoModel::findById($videoId);
        if (!$video) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Video no encontrado"
            ]);
            return;
        }

        $video
            ->setName($name)
            ->setDuration($time_string)
            ->setContentType($contentType)
            ->setAddress($address)
            ->setActive(true);

        $video->save();

        $response->json([
            "status" => true,
            "message" => "El video se actualizó éxitosamente"
        ]);
    }

    public function putLessonVideo(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $lessonId = intval($request->getParams("id"));

        $file = $request->getFiles("video");
        if (!$file) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Faltan parametros"
            ]);
            return;
        }

        $lesson = LessonModel::findById($lessonId);
        if (!$lesson) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Lección no encontrada"
            ]);
            return;
        }

        $getID3 = new getID3();
        $fileinfo = $getID3->analyze($file->getTmpName());

        $name = Uuid::uuid4()->toString();
        $ext = pathinfo($file->getName(), PATHINFO_EXTENSION);
        $contentType = $file->getType();
        $duration = round($fileinfo["playtime_seconds"]);
        
        $hours = floor($duration / 3600);
        $minutes = floor(($duration - ($hours * 3600)) / 60);
        $seconds = round($duration - ($hours * 3600) - ($minutes * 60));
        $time_string = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

        $address = UPLOADS_DIR . "/$name.$ext";
        
        move_uploaded_file($file->getTmpName(), $address);

        $video = new VideoModel([
            "name" => $name,
            "duration" => $time_string,
            "contentType" => $contentType,
            "address" => $address
        ]);

        $isCreated = $video->save();
        if (!$isCreated) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "No se pudo crear la imagen"
            ]);
            return;
        }

        $lesson->setVideoId($video->getId());
        $lesson->save();

        $response->json([
            "status" => true,
            "message" => "Video cargada",
            "id" => $video->getId()
        ]);
    }

    public function delete(Request $request, Response $response): void {
        $userId = $request->getSession()->get("id");
        $videoId = intval($request->getParams("id"));

        $video = VideoModel::findById($videoId);
        if (!$video) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Video no encontrado"
            ]);
            return;
        }

        $video
            ->setActive(false);

        $video->save();

        $response->json([
            "status" => true,
            "message" => "El video fue eliminado"
        ]);
    }

    public function getOne(Request $request, Response $response): void {
        $videoId = intval($request->getParams("id"));
        if (!Validate::uint($videoId)) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Identificador no válido"
            ]);
            return;
        }

        $userId = $request->getSession()->get("id");

        $videoRepository = new VideoRepository();
        $info = $videoRepository->video($userId, $videoId);
        if (!$info) {
            $response->setStatus(401)->json([
                "status" => false,
                "message" => "No estas autorizado"
            ]);
            return;
        }
/*
        if ($info["free"] && $info["paid"]) {
            // Si es gratis y pagado, entonces está disponible
            $contentAvailable = true;
        } elseif ($info["free"] && !$info["paid"]) {
            // Si es gratis y no es pagado, entonces está disponible
            $contentAvailable = true;
        } elseif (!$info["free"] && $info["paid"]) {
            // Si no es gratis pero es pagado, entonces está disponible
            $contentAvailable = true;
        } else {
            // Si no es gratis y no es pagado, entonces no está disponible
            $contentAvailable = false;
        }

        if ($info["price"] == 0.0) {
            $contentAvailable = true;
        }
        
        if (!$contentAvailable) {
            $response->setStatus(401)->json([
                "status" => false,
                "message" => "No estás autorizado"
            ]);
            return;
        }
*/
        $video = VideoModel::findById($videoId);
        if (!$video) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Video no encontrado"
            ]);
            return;
        }

        if (!$video->getActive()) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Video no encontrado"
            ]);
            return;
        }

        // que pasa si el video es eliminado? 
        // eso no deberia pasar pero hay que estar precavidos si pasa
        $data = file_get_contents($video->getAddress());
        
        $response->setContentType("video/mp4");
        $response->setHeader("Content-Length", strlen($data));
        $response->setHeader("Content-Disposition", 'inline; filename="' . $video->getName() . '"');
        $dt = new DateTime($video->getCreatedAt());
        $response->setHeader("Last-Modified", $dt->format('D, d M Y H:i:s \C\S\T'));
        $response->setBody($data);
    }
}
