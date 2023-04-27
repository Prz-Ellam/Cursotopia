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
    
    private const FIND_ONE_BY_COURSE_ID_AND_STUDENT_ID = <<<'SQL'
        SELECT
            enrollment_id,
            course_id,
            student_id,
            enrollment_is_finished,
            enrollment_enroll_date,
            enrollment_finish_date,
            enrollment_certificate_uid,
            enrollment_amount,
            payment_method_id,
            enrollment_last_time_checked,
            enrollment_created_at,
            enrollment_modified_at,
            enrollment_active
        FROM
            enrollments
        WHERE
            course_id = :course_id
            AND student_id = :student_id;
    SQL;

    private const COMPLETE_LESSON = <<<'SQL'
        CALL `complete_lesson`(
            :user_id,
            :lesson_id
        );
    SQL;

    private const VISIT_LESSON = <<<'SQL'
        CALL `visit_lesson`(
            :user_id,
            :lesson_id
        )
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

    public function findOneByCourseIdAndStudentId(int $courseId, int $studentId): ?array {
        $parameters = [
            "course_id" => $courseId,
            "student_id" => $studentId
        ];
        return DB::executeOneReader($this::FIND_ONE_BY_COURSE_ID_AND_STUDENT_ID, $parameters);
    }

    public function completeLesson(int $userId, int $lessonId): int {
        $parameters = [
            "user_id" => $userId,
            "lesson_id" => $lessonId
        ];
        return DB::executeNonQuery($this::COMPLETE_LESSON, $parameters);
    }

    public function visitLesson(int $userId, int $lessonId): int {
        $parameters = [
            "user_id" => $userId,
            "lesson_id" => $lessonId
        ];
        return DB::executeNonQuery($this::VISIT_LESSON, $parameters);
    }
}
