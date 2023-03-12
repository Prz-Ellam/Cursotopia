<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Video;
use Cursotopia\Repositories\VideoRepository;
use DateTime;
use getID3;

class VideoController {
    public function create(Request $request, Response $response): void {
        $file = $request->getFiles("video");
        if (!$file) {
            $response
                ->setStatus(400)
                ->json([
                    "status" => false,
                    "message" => "Faltan parametros"
                ]);
            return;
        }

        $getID3 = new getID3();
        $fileinfo = $getID3->analyze($file->getTmpName());

        $name = "video-" . time();
        $ext = pathinfo($file->getName(), PATHINFO_EXTENSION);
        $duration = round($fileinfo['playtime_seconds']);
        $address = $_SERVER["DOCUMENT_ROOT"] . "/uploads/$name.$ext";
        
        move_uploaded_file($file->getTmpName(), $address);

        $videoRepository = new VideoRepository();
        $video = new Video();
        $video
            ->setName($name)
            ->setDuration($duration)
            ->setAddress($address);
        $rowsAffected = $videoRepository->create($video);
        
        $response->json($rowsAffected);
    }

    public function update(Request $request, Response $response): void {

    }

    public function getOne(Request $request, Response $response): void {
        $id = $request->getParams("id");
        if (!((is_int($id) || ctype_digit($id)) && (int)$id > 0)) {
            $response
                ->setStatus(400)
                ->json([
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
