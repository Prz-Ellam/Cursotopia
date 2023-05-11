<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Repositories\CourseRepository;
use Cursotopia\Repositories\MainRepository;

class HomeController {
    /**
     * Página de inicio con los tops de cursos y estadisticas de la página
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function home(Request $request, Response $response): void {
        $mainRepository = new MainRepository();
        $stats = $mainRepository->homeStats();

        $courseRepository = new CourseRepository();
        $lastPublishedCourses = $courseRepository->findAllOrderByCreatedAt();
        $topRatedCourses = $courseRepository->findAllOrderByRates();
        $bestSellingCourses = $courseRepository->findAllOrderByEnrollments();

        $response->render("home", [
            "lastPublishedCourses" => $lastPublishedCourses,
            "topRatedCourses" => $topRatedCourses,
            "bestSellingCourses" => $bestSellingCourses,
            "stats" => $stats
        ]);
    }

    /**
     * Devolver a /home
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function redirect(Request $request, Response $response): void {
        $response->redirect("/home");
    }
}
