<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Review;
use Cursotopia\Repositories\ReviewRepository;

class ReviewController {
    public function create(Request $request, Response $response): void {
        $message = $request->getBody("message");
        $rate = $request->getBody("rate");
        $courseId = $request->getBody("courseId");

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

    }

    public function delete(Request $request, Response $response): void {
        
    }
}
