<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Review;
use Cursotopia\Repositories\CourseRepository;
use Cursotopia\Models\EnrollmentModel;
use Cursotopia\Models\ReviewModel;
use Cursotopia\Models\CourseModel;
use Cursotopia\Models\UserModel;
use Cursotopia\Repositories\ReviewRepository;

class ReviewController {
    public function create(Request $request, Response $response): void {

        try{
            // Obtener el parametro del curso
            // TODO: Un usuario solo puede hacer una reseña?
            [
                "message" => $message,
                "rate" => $rate,
                "courseId" => $courseId
            ] = $request->getBody();

            //Validar que el curso existe

            $requestedCourse = CourseModel::findById($courseId);
            if (!$requestedCourse) {
                $response->json([
                    "status" => false,
                    "message" => "El curso no existe"
                ]);
                return;
            }

            $session = $request->getSession();
            $userId = $session->get("id");
            $role = $session->get("role");

            //Validar que el usuario haciendo la reseña tenga rol estudiante

            if ($role!=3) {
                $response->setStatus(409)->json([
                    "status" => false,
                    "message" => "El usuario no tiene rol estudiante"
                ]);
                return;
            }

            //Validar que esté inscrito al curso

            $enroll= EnrollmentModel::findOneByCourseIdAndStudentId($courseId,$userId);

            if (!$enroll) {
                $response->setStatus(409)->json([
                    "status" => false,
                    "message" => "El estudiante no está inscrito a este curso"
                ]);
                return;
            }

            // Validar que la persona que esta haciendo la reseña acabó el curso

            if (!$enroll->getEnrollmentIsFinished()) {
                $response->setStatus(409)->json([
                    "status" => false,
                    "message" => "El estudiante no ha concluido el curso"
                ]);
                return;
            }

            //Validar que no haya dejado una reseña al curso previamente

            $userReview= ReviewModel::findOneByCourseAndUserId($courseId,$userId);

            if ($userReview) {
                $response->setStatus(409)->json([
                    "status" => false,
                    "message" => "El estudiante ya dejó una reseña en este curso previamente"
                ]);
                return;
            }    

            $review = new ReviewModel([
                "message"=>$message,
                "rate"=>$rate,
                "courseId"=>$courseId,
                "userId"=>$userId
            ]);
            $review->save();

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

    public function getMoreReviews(Request $request, Response $response): void {
     
        $courseId = intval($request->getParams("courseId"));
        $pageNum = intval($request->getParams("pageNum"));
        $pageSize = intval($request->getParams("pageSize"));

        //Validar que sean enteros

        if ($pageNum == false) {
            $response->json([
                "status" => false,
                "message" => $pageNum
            ]);
            return;
        } 

        if ($pageSize === false) {
            $response->json([
                "status" => false,
                "message" => "El tamaño de página no es válido"
            ]);
            return;
        } 

        //Validar que el curso exista

        $requestedCourse = CourseModel::findById($courseId);
        if (!$requestedCourse) {
            $response->json([
                "status" => false,
                "message" => "El curso no existe"
            ]);
            return;
        }

        $review = new ReviewModel();
        $reviews=$review->findByCourse($courseId,$pageNum,$pageSize);

        if(!$reviews){
            $response->json([
                "status" => false,
                "message" => "No se encontraron los cursos"
            ]);
            return;
        }

        $response->setStatus(201)->json([
            "status" => true,
            "message" => "Se encontraron los cursos",
            "reviews" => $reviews
        ]);
                
    }

    public function update(Request $request, Response $response): void {
        $reviewId = $request->getParams("reviewId");
        [
            "message" => $message,
            "rate" => $rate
        ] = $request->getBody();

        // Validar que la reseña exista
        /*
            $requestedReview = Review::findById($reviewId);
            if (!$requestedReview) {
                $response->json([
                    "status" => false,
                    "message" => "La reseña no existe"
                ]);
            }
        */

        //$reviewRepository = new ReviewRepository();
        //$rowsAffected = $reviewRepository->update();
    }

    public function delete(Request $request, Response $response): void {
        $reviewId = $request->getParams("reviewId");

        // Validar que la reseña exista
            $requestedReview = ReviewModel::findById($reviewId);
            if (!$requestedReview) {
                $response->json([
                    "status" => false,
                    "message" => "La reseña no existe"
                ]);
            }

        $reviewModel = new ReviewModel();
        $isDeleted = $reviewModel->delete($reviewId);

        if($isDeleted){
            $response->json([
                "status" => true,
                "message" => $isDeleted
            ]);
        }else{
            $response->json([
                "status" => false,
                "message" => "No se pudo eliminar"
            ]);
        }   
        
    }

    public function paymentMethod(Request $request, Response $response): void {
        $courseId = $request->getQuery("courseId");
        if (!$courseId || !((is_int($courseId) || ctype_digit($courseId)) && (int)$courseId > 0)) {
            $response->setStatus(404)->render('404');
            return;
        }
    
        $courseRepository = new CourseRepository();
        $course = $courseRepository->findOneById($courseId);
        if (!$course) {
            $response->setStatus(404)->render('404');
            return;
        }
    
        $response->render("payment-method", [ "course" => $course ]);
    }
}
