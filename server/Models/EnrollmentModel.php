<?php

namespace Cursotopia\Models;

use Cursotopia\Repositories\EnrollmentRepository;

class EnrollmentModel {
    public static function completeLesson(int $userId, int $lessonId): bool {
        $enrollmentRepository = new EnrollmentRepository();
        $status = $enrollmentRepository->completeLesson($userId, $lessonId);
        return $status ? true : false;
    }

    public static function visitLesson(int $userId, int $lessonId): bool {
        $enrollmentRepository = new EnrollmentRepository();
        $status = $enrollmentRepository->visitLesson($userId, $lessonId);
        return $status ? true : false;
    }
}
