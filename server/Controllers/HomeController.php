<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Models\CategoryModel;
use Cursotopia\Models\CourseModel;
use Cursotopia\Repositories\ChatRepository;
use Cursotopia\Repositories\CourseRepository;
use Cursotopia\Repositories\MainRepository;
use DateTime;

class HomeController {
    public function home(Request $request, Response $response): void {
        $session = $request->getSession();
        $id = $session->get("id");
        $role = $session->get("role");

        $mainRepository = new MainRepository();
        $stats = $mainRepository->homeStats();

        $courseRepository = new CourseRepository();
        $courses = $courseRepository->findAllOrderByCreatedAt();
        $coursesRates = $courseRepository->findAllOrderByRates();
        $bestSellingCourses = $courseRepository->findAllOrderByEnrollments();

        $response->render('home', [
            "id" => $id,
            "role" => $role,
            "lastPublishedcourses" => $courses,
            "topRatedCourses" => $coursesRates,
            "bestSellingCourses" => $bestSellingCourses,
            "stats" => $stats
        ]);
    }

    public function chat(Request $request, Response $response): void {
        $session = $request->getSession();
        $id = $session->get("id");
        
        $chatRepository = new ChatRepository();
        $chats = $chatRepository->findAllByUserId($id);
        
        $response->render("chat", [
            "chats" => $chats
        ]); 
    }
}
