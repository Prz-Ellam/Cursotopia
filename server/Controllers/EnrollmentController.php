<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Enrollment;
use Cursotopia\Helpers\Format;
use Cursotopia\Models\CourseModel;
use Cursotopia\Models\UserModel;
use Cursotopia\Repositories\EnrollmentRepository;

class EnrollmentController {
    public function certificate(Request $request, Response $response): void {
        $session = $request->getSession();
        $id = $session->get("id");
    
        $user = UserModel::findById($id)->toObject();
        $name = $user["name"] . " " . $user["lastName"];
    
        $courseId = $request->getQuery("course");
        if (!$courseId) {
            $response->setStatus(404)->render("404");
            return;
        }
    
        // Validar tambien que el curso exists
        $course = CourseModel::findById($courseId);
        if (!$course) {
            $response->setStatus(404)->render("404");
            return;
        }
        $course = $course->toObject();
        $courseTitle = $course["title"];
    
        $enrollmentRepository = new EnrollmentRepository();
        $enrollment = $enrollmentRepository->findOneByCourseIdAndStudentId($courseId, $id);
        if (!$enrollment) {
            $response->setStatus(404)->render("404");
            return;
        }

        
        if (!$enrollment["enrollmentIsFinished"]) {
            $response->setStatus(404)->render("404");
            return;
        }
    
        $instructor = UserModel::findById($course["instructorId"]);
        if (!$instructor) {
            $response->setStatus(404)->render("404");
            return;
        }
        $instructor = $instructor->toObject();
        $instructorName = $instructor["name"] . " " . $instructor["lastName"];
    
        // Cargar la imagen de plantilla
        // Definir la ubicación de la imagen y la fuente personalizada
        $imgPath = "certificate.png";
        $fontPath = "Lato/Lato-Bold.ttf";
    
        // Crear una imagen a partir del archivo PNG
        $image = imagecreatefrompng($imgPath);
    
        // Establecer el color del texto a rojo
        $color = imagecolorallocate($image, 86, 80, 222);
    
        // Establecer el tamaño de fuente deseado
        $fontSize = 25;
        $text = $name;
    
        // Obtener las dimensiones de la imagen y del texto
        $imageWidth = imagesx($image);
        do {
            $fontSize--;
            $fontBox = imagettfbbox($fontSize, 0, $fontPath, $text);
            $textWidth = $fontBox[2] - $fontBox[0];
        } while ($textWidth > $imageWidth);
    
        // Calcular la posición del texto para centrarlo horizontalmente
        $x = intval(($imageWidth - $textWidth) / 2);
        $y = 289;
    
        // Escribir el texto en la imagen centrado
        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $text);
    
        $fontSize = 25;
        do {
            $fontSize--;
            $fontBox = imagettfbbox($fontSize, 0, $fontPath, $courseTitle);
            $textWidth = $fontBox[2] - $fontBox[0];
        } while ($textWidth > $imageWidth);
    
        $x = intval(($imageWidth - $textWidth) / 2);
        $y = 393;
    
        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $courseTitle);

        $color = imagecolorallocate($image, 215, 182, 89);
        $fontSize = 25;
        do {
            $fontSize--;
            $fontBox = imagettfbbox($fontSize, 0, $fontPath, $instructorName);
            $textWidth = $fontBox[2] - $fontBox[0];
        } while ($textWidth > $imageWidth);
    
        $x = intval(($imageWidth - $textWidth) / 2);
        $y = 510;
    
        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $instructorName);
    
        // UID
        $color = imagecolorallocate($image, 64, 64, 64);
        $fontSize = 18;
        $fontPath = "Lato/Lato-Regular.ttf";
        $x = 480;
        $y = 670;
        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $enrollment["certificateUid"]);
    
        $finishDate = Format::date($enrollment["finishDate"]);
        $x = 350;
        $y = 636;
        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $finishDate);
    
        // Mostrar la imagen en el navegador
        ob_start();
        imagepng($image);
        $png = ob_get_clean();
    
        // Convertir la imagen en formato PNG a base64
        $base64 = base64_encode($png);
    
        // Almacenar la imagen en la variable $certificate como una cadena de texto base64
        $certificate = "data:image/png;base64," . $base64;
    
        // Liberar la memoria utilizada por la imagen
        imagedestroy($image);

        $response->render("certificate", [ "certificate" => $certificate ]);
    }
    
    public function create(Request $request, Response $response): void {
        $session = $request->getSession();

        $courseId = $request->getBody("courseId");
        $studentId = $session->get("id");
        $amount = $request->getBody("amount");
        $paymentMethodId = $request->getBody("paymentMethodId");

        // Validar que el curso exista
        // Validar que el método de pago existe

        $enrollment = new Enrollment();
        $enrollment
            ->setCourseId($courseId)
            ->setStudentId($studentId)
            ->setAmount($amount)
            ->setPaymentMethodId($paymentMethodId);

        $enrollmentRepository = new EnrollmentRepository();
        $rowsAffected = $enrollmentRepository->create($enrollment);

        $response->json([
            "status" => true,
            "message" => $rowsAffected
        ]);
    }
}
