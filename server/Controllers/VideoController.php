<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;
use Cursotopia\Helpers\Validate;
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

    }

    public function getOne(Request $request, Response $response): void {
        $id = intval($request->getParams("id"));
        if (!Validate::uint($id)) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "Identificador no válido"
            ]);
            return;
        }

        $userId = $request->getSession()->get("id");

        $videoRepository = new VideoRepository();
        $info = $videoRepository->video($userId, $id);
        if (!$info) {
            $response->setStatus(401)->json([
                "status" => false,
                "message" => "No estas autorizado"
            ]);
            return;
        }

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

        $video = VideoModel::findById($id);
        if (!$video) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Video no encontrado"
            ]);
            return;
        }

        // que pasa si el video es eliminado? 
        // eso no deberia pasar pero hay que estar precavidos si pasa
        $data = file_get_contents($video["address"]);
        
        $response->setContentType("video/mp4");
        $response->setHeader("Content-Length", strlen($data));
        $response->setHeader("Content-Disposition", 'inline; filename="' . $video["name"] . '"');
        $dt = new DateTime($video["createdAt"]);
        $response->setHeader("Last-Modified", $dt->format('D, d M Y H:i:s \C\S\T'));
        $response->setBody($data);
    }
}
