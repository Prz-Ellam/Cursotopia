<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Course;

class CourseRepository {
    private const CREATE = <<<'SQL'
        INSERT INTO courses(
            `course_title`,
            `course_description`,
            `course_price`,
            `image_id`,
            `instructor_id`
        )
        SELECT
            :title,
            :description,
            :price,
            :image_id,
            :instructor_id
        FROM
            dual
        WHERE
            :title IS NOT NULL
            AND :description IS NOT NULL
            AND :price IS NOT NULL
            AND :image_id IS NOT NULL
            AND :instructor_id IS NOT NULL
    SQL;

    private const FIND_ONE = <<<'SQL'
        SELECT
            `course_id` AS `id`,
            `course_title` AS `title`,
            `course_description` AS `description`,
            `course_price` AS `price`,
            `image_id` AS `imageId`,
            `instructor_id` AS `instructorId`,
            `course_approved` AS `approved`,
            `course_approved_by` AS `approvedBy`,
            `course_created_at` AS `createdAt`,
            `course_modified_at` AS `modifiedAt`,
            `course_active` AS `active`
        FROM
            `courses`
        WHERE
            `course_id` = :id
    SQL;

    private const COURSE_DETAILS_FIND_ONE = <<<'SQL'
        SELECT
            `id`,
            `title`,
            `description`,
            `price`,
            `imageId`,
            `createdAt`,
            `modifiedAt`,
            `instructorName`,
            `rates`,
            `reviews`,
            `students`,
            `levels`,
            `duration`
        FROM
            `course_details`
        WHERE
            `id` = :id
    SQL;

    private const KARDEX_FIND_ALL_BY_USER_ID = <<<'SQL'
        SELECT
            `course_id` AS `courseId`,
            `student_id` AS `studentId`,
            `course_title` AS `title`,
            `enrollment_enroll_date` AS `enrollDate`,
            `enrollment_last_time_checked` AS `lastTimeChecked`,
            `enrollment_finish_date` AS `finishDate`,
            `enrollment_is_finished` AS `isFinished`,
            `enrollment_certificate_uid` AS `certificateUid`,
            `enrollment_progress` AS `progress`
        FROM
            `kardex`
        WHERE
            `student_id` = :user_id
    SQL;

    public function create(Course $course): int {
        $parameters = [
            "title" => $course->getTitle(),
            "description" => $course->getDescription(),
            "price" => $course->getPrice(),
            "image_id" => $course->getImageId(),
            "instructor_id" => $course->getInstructorId()
        ];
        return DB::executeNonQuery($this::CREATE, $parameters);
    }

    public function findOneById(int $id): array {
        $parameters = [
            "id" => $id
        ];
        return DB::executeOneReader($this::FIND_ONE, $parameters);
    }

    public function courseDetailsfindOneById(int $id): array {
        $parameters = [
            "id" => $id
        ];
        return DB::executeOneReader($this::COURSE_DETAILS_FIND_ONE, $parameters);
    }

    public function kardexFindAllByUserId(int $userId): array {
        $parameters = [
            "user_id" => $userId
        ];
        return DB::executeReader($this::KARDEX_FIND_ALL_BY_USER_ID, $parameters);
    }
}
