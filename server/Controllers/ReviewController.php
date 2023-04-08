<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Review;
use Cursotopia\Repositories\ReviewRepository;

class ReviewController {
    public function create(Request $request, Response $response): void {
        // Obtener el parametro del curso
        $courseId = $request->getParams("courseId");

        [
            "message" => $message,
            "rate" => $rate
        ] = $request->getBody();

        // Validar que la persona que esta haciendo la reseña acabo el curso
        /*
            userId -> courseIsFinished
        
        */

        $session = $request->getSession();
        $userId = $session->get("id");

        $review = new Review();
        $review
            ->setMessage($message)
            ->setRate($rate)
            ->setCourseId($courseId)
            ->setUserId($userId);

        $reviewRepository = new ReviewRepository();
        $rowsAffected = $reviewRepository->create($review);

        $response->json([
            "status" => true,
            "message" => $rowsAffected
        ]);
    }

    public function update(Request $request, Response $response): void {
        $reviewId = $request->getParams("reviewId");
        [
            "message" => $message,
            "rate" => $rate
        ] = $request->getBody();

        //$reviewRepository = new ReviewRepository();
        //$rowsAffected = $reviewRepository->update();
    }

    public function delete(Request $request, Response $response): void {
        $courseId = $request->getParams("courseId");
        $reviewId = $request->getParams("reviewId");

        $reviewRepository = new ReviewRepository();
        $rowsAffected = $reviewRepository->delete($reviewId);

        $response->json([
            "status" => true,
            "message" => $rowsAffected
        ]);
    }
}
