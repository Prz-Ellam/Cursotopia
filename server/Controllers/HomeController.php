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

    public function search(Request $request, Response $response): void {
        function validateDate($fecha) {
            $d = DateTime::createFromFormat('Y-m-d', $fecha);
            return $d && $d->format('Y-m-d') === $fecha;
        }

        $title = $request->getQuery("title", null);
        $from = $request->getQuery("from", null);
        $to = $request->getQuery("to", null);
        $instructorId = $request->getQuery("instructor", null);
        $categoryId = $request->getQuery("category", null);
        $page = $request->getQuery("page", 1);

        $perPageElement = 12;
        $start = ($page - 1) * $perPageElement;

        
        $limit = $perPageElement;
        $offset = $start;

        if (!((is_int($instructorId) || ctype_digit($instructorId)) && (int)$instructorId > 0)) {
            $instructorId = null;
        }

        if (!((is_int($categoryId) || ctype_digit($categoryId)) && (int)$categoryId > 0)) {
            $categoryId = null;
        }

        if (!$from || !validateDate($from)) {
            $from = null;
        }

        if (!$to || !validateDate($to)) {
            $to = null;
        }

        $total = CourseModel::findSearchTotal($title, $instructorId, $categoryId, $from, $to,
        $limit, 0);

        $totalPages = ceil($total / $perPageElement);

        if ($page > $totalPages) {
            $response->setStatus(404)->render("404");
            return;
        }

        $courses = CourseModel::findSearch($title, $instructorId, $categoryId, $from, $to,
            $limit, $offset);

        $categories = CategoryModel::findAll();

        $response->render("search", [
            "courses" => $courses,
            "categories" => $categories,
            "title" => $title ?? "",
            "from" => $from ?? "",
            "to" => $to ?? "",
            "instructorId" => $instructorId,
            "page" => $page,
            "totalPages" => $totalPages,
            "totalButtons" => $totalPages > 5 ? 5 : $totalPages 
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
