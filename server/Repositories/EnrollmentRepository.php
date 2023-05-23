<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Enrollment;

class EnrollmentRepository extends DB implements Repository {
    private const CREATE = <<<'SQL'
        CALL `enrollment_pay`(
            :course_id, 
            :student_id, 
            :amount, 
            :payment_method_id,
            @enrollment_id
        )
    SQL;

    private const FIND_ONE_BY_COURSE_AND_STUDENT = <<<'SQL'
        CALL `enrollment_find_one_by_course_and_student`(:course_id, :student_id)
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

    private const CERTIFICATE_FIND_ONE = <<<'SQL'
        CALL `certificate_find_one`(:student_id, :course_id)
    SQL;

    public function create(Enrollment $enrollment): int {
        $parameters = [
            "course_id" => $enrollment->getCourseId(),
            "student_id" => $enrollment->getStudentId(),
            "amount" => $enrollment->getAmount(),
            "payment_method_id" => $enrollment->getPaymentMethodId()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function findOneByCourseAndStudent(?int $courseId, ?int $studentId): ?array {
        $parameters = [
            "course_id" => $courseId,
            "student_id" => $studentId
        ];
        return $this::executeOneReader($this::FIND_ONE_BY_COURSE_AND_STUDENT, $parameters);
    }

    public function completeLesson(int $userId, int $lessonId): int {
        $parameters = [
            "user_id" => $userId,
            "lesson_id" => $lessonId
        ];
        return $this::executeNonQuery($this::COMPLETE_LESSON, $parameters);
    }

    public function visitLesson(int $userId, int $lessonId): int {
        $parameters = [
            "user_id" => $userId,
            "lesson_id" => $lessonId
        ];
        return $this::executeNonQuery($this::VISIT_LESSON, $parameters);
    }

    public function certificateFindOne(?int $studentId, ?int $courseId): ?array {
        $parameters = [
            "student_id" => $studentId,
            "course_id" => $courseId
        ];
        return $this::executeOneReader($this::CERTIFICATE_FIND_ONE, $parameters);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @enrollment_id AS enrollmentId", [])["enrollmentId"];
    }
}
