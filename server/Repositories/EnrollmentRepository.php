<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Contracts\EnrollmentRepositoryInterface;
use Cursotopia\Entities\Enrollment;

class EnrollmentRepository implements EnrollmentRepositoryInterface {
    private const CREATE = <<<'SQL'
        INSERT INTO enrollments(
            course_id,
            student_id,
            enrollment_amount,
            payment_method_id
        )
        SELECT
            :course_id,
            :student_id,
            :amount,
            :payment_method_id
        WHERE
            :course_id IS NOT NULL
            AND :student_id IS NOT NULL
            AND :amount IS NOT NULL
            AND :payment_method_id IS NOT NULL
    SQL;
    
    public function create(Enrollment $enrollment): int {
        $parameters = [
            "course_id" => $enrollment->getCourseId(),
            "student_id" => $enrollment->getStudentId(),
            "amount" => $enrollment->getAmount(),
            "payment_method_id" => $enrollment->getPaymentMethodId()
        ];
        return DB::executeNonQuery($this::CREATE, $parameters);
    }
}
