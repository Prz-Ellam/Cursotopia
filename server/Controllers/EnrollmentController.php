<?php

namespace Cursotopia\Controllers;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Cursotopia\Entities\Enrollment;
use Cursotopia\Repositories\EnrollmentRepository;

class EnrollmentController {
    public function create(Request $request, Response $response): void {
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

        $enrollmentRepository = new EnrollmentRepository();
        $rowsAffected = $enrollmentRepository->create($enrollment);

        $response->json([
            "status" => true,
            "message" => $rowsAffected
        ]);
    }
}
