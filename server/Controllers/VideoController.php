<?php

namespace Cursotopia\Controllers;

use Bloom\Database\DB;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Video;
use Cursotopia\Helpers\Validate;
use Cursotopia\Repositories\VideoRepository;
use DateTime;
use getID3;

class VideoController {
    public function create(Request $request, Response $response): void {
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

        $name = "video-" . time();
        $ext = pathinfo($file->getName(), PATHINFO_EXTENSION);
        $contentType = $file->getType();
        $duration = round($fileinfo['playtime_seconds']);
        
        $hours = floor($duration / 3600);
        $minutes = floor(($duration - ($hours * 3600)) / 60);
        $seconds = round($duration - ($hours * 3600) - ($minutes * 60));
        $time_string = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        $address = UPLOADS_DIR . "/$name.$ext";
        
        move_uploaded_file($file->getTmpName(), $address);

        $videoRepository = new VideoRepository();
        $video = new Video();
        $video
            ->setName($name)
            ->setDuration($time_string)
            ->setContentType($contentType)
            ->setAddress($address);
        $rowsAffected = $videoRepository->create($video);
        $videoId = DB::lastInsertId();
        
        $response->json([
            "status" => true,
            "id" => $videoId,
            "message" => $rowsAffected
        ]);
    }

    public function update(Request $request, Response $response): void {

    }

    public function getOne(Request $request, Response $response): void {
        $id = $request->getParams("id");
        if (!Validate::uint($id)) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "ID is not valid"
            ]);
            return;
        }

        $videoRepository = new VideoRepository();
        $video = $videoRepository->findOne($id);

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
