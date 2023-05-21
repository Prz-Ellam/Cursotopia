<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Helpers\Validate;
use Cursotopia\Models\EnrollmentModel;
use Cursotopia\Models\ReviewModel;
use Cursotopia\Models\CourseModel;
use Cursotopia\Models\UserModel;
use Cursotopia\ValueObjects\Roles;
use Exception;

class ReviewController {    
    public function create(Request $request, Response $response): void {
        try {
            $userId = intval($request->getSession()->get("id"));
            [
                "message" => $message,
                "rate" => $rate,
                "courseId" => $courseId
            ] = $request->getBody();

            // Verificar que el curso existe
            $course = CourseModel::findById($courseId);
            if (!$course) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Curso no encontrado"
                ]);
                return;
            }

            if (!$course->isActive()) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Curso no encontrado"
                ]);
                return;
            }

            $user = UserModel::findById($userId);
            if (!$user) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "Usuario no encontrado"
                ]);
                return;
            }

            //Validar que esté inscrito al curso
            $enroll = EnrollmentModel::findOneByCourseAndStudent($courseId, $userId);
            if (!$enroll) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "El estudiante no está inscrito a este curso"
                ]);
                return;
            }

            // Validar que la persona que esta haciendo la reseña acabó el curso
            if (!$enroll->getIsFinished()) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "El estudiante no ha concluido el curso"
                ]);
                return;
            }

            //Validar que no haya dejado una reseña al curso previamente
            $userReview = ReviewModel::findOneByCourseAndUser($courseId, $userId);
            if ($userReview) {
                $response->setStatus(409)->json([
                    "status" => false,
                    "message" => "El estudiante ya dejó una reseña en este curso previamente"
                ]);
                return;
            }    

            $review = new ReviewModel([
                "message" => $message,
                "rate" => $rate,
                "courseId" => $courseId,
                "userId" => $userId
            ]);

            $isCreated = $review->save();
            if (!$isCreated) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "No se pudo crear la reseña"
                ]);
                return;
            }

            $response->setStatus(201)->json([
                "status" => true,
                "message" => "La reseña fue agregada éxitosamente",
            ]);
        }
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "Ocurrió un error en el servidor"
            ]);
        }
    }

    public function delete(Request $request, Response $response): void {
        try {
            $reviewId = intval($request->getParams("id"));
            $userId = intval($request->getSession()->get("id"));
            $role = $request->getSession()->get("role");

            // Validar que la reseña exista
            $review = ReviewModel::findById($reviewId);
            if (!$review) {
                $response->setStatus(404)->json([
                    "status" => false,
                    "message" => "La reseña no existe"
                ]);
                return;
            }

            // Solo los administradores o el usuario creador pueden borrar reseñas
            if ($userId != $review->getUserId() && $role != Roles::ADMIN->value) {
                $response->setStatus(403)->json([
                    "status" => false,
                    "message" => "No autorizado"
                ]);
                return;
            }

            $review
                ->setActive(false);

            $isDeleted = $review->save();
            if (!$isDeleted) {
                $response->setStatus(400)->json([
                    "status" => false,
                    "message" => "No se pudo eliminar la reseña"
                ]);
                return;
            }

            $response->json([
                "status" => true,
                "message" => "La reseña fue eliminada éxitosamente"
            ]);
        }
        catch (Exception $exception) {
            $response->setStatus(500)->json([
                "status" => false,
                "message" => "Ocurrió un error en el servidor"
            ]);
        }
    }

    public function getMoreReviews(Request $request, Response $response): void {
        $courseId = intval($request->getParams("courseId"));
        $pageNum = intval($request->getParams("pageNum"));
        $pageSize = intval($request->getParams("pageSize"));

        //Validar que sean enteros
        if ($courseId == false) {
            $response->json([
                "status" => false,
                "message" => "El curso debe ser un entero positivo"
            ]);
            return;
        }

        if ($pageNum == false) {
            $response->json([
                "status" => false,
                "message" => "El número de página debe ser un entero positivo"
            ]);
            return;
        } 

        if ($pageSize === false) {
            $response->json([
                "status" => false,
                "message" => "El tamaño de página debe ser un entero positivo"
            ]);
            return;
        } 

        //Validar que el curso exista
        $course = CourseModel::findById($courseId);
        if (!$course) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "El curso no existe"
            ]);
            return;
        }

        if (!$course->isActive()) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Curso no encontrado"
            ]);
            return;
        }

        $reviews = ReviewModel::findByCourse($courseId, $pageNum, $pageSize);
        $reviewsTotal = ReviewModel::findTotalByCourse($courseId);

        if (!$reviews) {
            $response->json([
                "status" => true,
                "message" => "No se encontraron más reseñas",
                "reviews" => [],
                "total" => 0
            ]);
            return;
        }

        $response->json([
            "status" => true,
            "message" => "Se encontraron los cursos",
            "reviews" => $reviews,
            "total" => $reviewsTotal
        ]);
    }

    public function getTotalCourseReviews(Request $request, Response $response): void {
        $courseId = intval($request->getParams("courseId"));
        if (!Validate::uint($courseId)) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "El curso debe ser un entero positivo"
            ]);
            return;
        }

        //Validar que el curso exista
        $course = CourseModel::findById($courseId);
        if (!$course) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Curso no encontrado"
            ]);
            return;
        }

        if (!$course->isActive()) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "Curso no encontrado"
            ]);
            return;
        }

        $reviewsTotal = ReviewModel::findTotalByCourse($courseId);
        $response->json($reviewsTotal);
    }
}
