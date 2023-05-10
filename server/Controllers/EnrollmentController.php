<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Enrollment;
use Cursotopia\Helpers\Format;
use Cursotopia\Models\CourseModel;
use Cursotopia\Models\EnrollmentModel;
use Cursotopia\Repositories\EnrollmentRepository;

class EnrollmentController {
    public function certificate(Request $request, Response $response): void {
        $id = $request->getSession()->get("id");

        $courseId = $request->getQuery("course");
        if (!$courseId) {
            $response->setStatus(404)->render("404");
            return;
        }

        $certificate = EnrollmentModel::findOneCertificate($id, $courseId);
        if (!$certificate) {
            $response->setStatus(404)->render("404");
            return;
        }
    
        // Cargar la imagen de plantilla
        // Definir la ubicación de la imagen y la fuente personalizada
        $imgPath = "certificate.png";
        $fontBoldPath = "Lato/Lato-Bold.ttf";
        $fontRegularPath = "Lato/Lato-Regular.ttf";
    
        // Crear una imagen a partir del archivo PNG
        $image = imagecreatefrompng($imgPath);
    
        // Establecer el color del texto a rojo
        $color = imagecolorallocate($image, 86, 80, 222);
    
        // Establecer el tamaño de fuente deseado
        $fontSize = 25;
    
        // Obtener las dimensiones de la imagen y del texto
        $imageWidth = imagesx($image);
        do {
            $fontSize--;
            $fontBox = imagettfbbox($fontSize, 0, $fontRegularPath, $certificate["student"]);
            $textWidth = $fontBox[2] - $fontBox[0];
        } while ($textWidth > $imageWidth);
    
        // Calcular la posición del texto para centrarlo horizontalmente
        $x = intval(($imageWidth - $textWidth) / 2);
        $y = 289;
    
        // Escribir el texto en la imagen centrado
        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontBoldPath, $certificate["student"]);
    
        $fontSize = 25;
        do {
            $fontSize--;
            $fontBox = imagettfbbox($fontSize, 0, $fontBoldPath, $certificate["course"]);
            $textWidth = $fontBox[2] - $fontBox[0];
        } while ($textWidth > $imageWidth);
    
        $x = intval(($imageWidth - $textWidth) / 2);
        $y = 393;
    
        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontBoldPath, $certificate["course"]);

        $color = imagecolorallocate($image, 215, 182, 89);
        $fontSize = 25;
        do {
            $fontSize--;
            $fontBox = imagettfbbox($fontSize, 0, $fontBoldPath, $certificate["instructor"]);
            $textWidth = $fontBox[2] - $fontBox[0];
        } while ($textWidth > $imageWidth);
    
        $x = intval(($imageWidth - $textWidth) / 2);
        $y = 510;
    
        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontBoldPath, $certificate["instructor"]);
    
        // UID
        $color = imagecolorallocate($image, 64, 64, 64);
        $fontSize = 18;
        $x = 480;
        $y = 670;
        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontRegularPath, $certificate["certificateId"]);
    
        $finishDate = Format::date($certificate["finishDate"]);
        $x = 350;
        $y = 636;
        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontRegularPath, $finishDate);
    
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
        $studentId = $request->getSession()->get("id");
        $courseId = $request->getBody("courseId");
        $amount = $request->getBody("amount");
        $paymentMethodId = $request->getBody("paymentMethodId");

        // Validar que el curso exista
        $requestedCourse = CourseModel::findById($courseId);
        if (!$requestedCourse) {
            $response->setStatus(404)->json([
                "status" => false,
                "message" => "El curso no existe"
            ]);
            return;
        }

        // Validar que el método de pago existe
        $enrollment = new EnrollmentModel([
            "courseId" => $courseId,
            "studentId" => $studentId,
            "amount" => $amount,
            "paymentMethodId" => $paymentMethodId
        ]);

        $isCreated = $enrollment->save();
        if (!$isCreated) {
            $response->setStatus(400)->json([
                "status" => false,
                "message" => "No se pudo crear la inscripción"
            ]);
            return;
        }

        $response->json([
            "status" => true,
            "message" => "La inscripción se creó éxitosamente"
        ]);
    }

    public function pay(Request $request, Response $response): void {
        $session = $request->getSession();

        $courseId = $request->getBody("courseId");
        $studentId = $session->get("id");
        $amount = $request->getBody("amount");
        $paymentMethodId = $request->getBody("paymentMethodId");

        $enrollment = new Enrollment();
        $enrollment
            ->setCourseId($courseId)
            ->setStudentId($studentId)
            ->setAmount($amount)
            ->setPaymentMethodId($paymentMethodId);
    }
}
