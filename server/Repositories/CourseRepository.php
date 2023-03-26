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
            `course_image_id`,
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
            `instructorId`,
            `approved`,
            `approvedBy`,
            `createdAt`,
            `modifiedAt`,
            `active`,
            `levels`,
            `rates`,
            `reviews`,
            `instructor` AS `instructorName`,
            `duration`,
            `enrollments` AS `students`
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

    private const FIND_ALL_ORDER_BY_CREATED_AT = <<<'SQL'
        SELECT
            c.course_id AS `id`,
            c.course_title AS `title`,
            c.course_description AS `description`,
            c.course_price AS `price`,
            c.course_image_id AS `imageId`,
            c.instructor_id AS `instructorId`,
            c.course_approved AS `approved`,
            c.course_approved_by AS `approvedBy`,
            c.course_created_at AS `createdAt`,
            c.course_modified_at AS `modifiedAt`,
            c.course_active AS `active`,
            COUNT(DISTINCT l.level_id) AS `levels`,
            IF(AVG(r.review_rate) IS NULL, 'No reviews', AVG(r.review_rate)) `rates`,
            CONCAT(u.user_name, ' ', u.user_last_name) `instructor`,
            SUM(TIME_TO_SEC(v.video_duration)) / 3600.0 AS `duration`,
            COUNT(DISTINCT e.enrollment_id) AS `enrollments`
        FROM
            `courses` AS c
        INNER JOIN
            levels AS l
        ON
            c.course_id = l.course_id
        INNER JOIN
            lessons AS le
        ON
            l.level_id = le.level_id
        LEFT JOIN
            videos AS v
        ON
            le.video_id = v.video_id
        LEFT JOIN
            reviews AS r
        ON
            c.course_id = r.course_id
        INNER JOIN
            users AS u
        ON
            c.instructor_id = u.user_id
        LEFT JOIN
            enrollments AS e
        ON
            c.course_id = e.course_id
        WHERE
            c.course_active = TRUE
            AND c.course_approved = TRUE
        GROUP BY
            c.course_id
        ORDER BY
            `course_created_at` DESC
    SQL;

    private const FIND_ALL_ORDER_BY_RATES = <<<'SQL'
        SELECT
            c.course_id AS `id`,
            c.course_title AS `title`,
            c.course_description AS `description`,
            c.course_price AS `price`,
            c.course_image_id AS `imageId`,
            c.instructor_id AS `instructorId`,
            c.course_approved AS `approved`,
            c.course_approved_by AS `approvedBy`,
            c.course_created_at AS `createdAt`,
            c.course_modified_at AS `modifiedAt`,
            c.course_active AS `active`,
            COUNT(DISTINCT l.level_id) AS `levels`,
            IF(AVG(r.review_rate) IS NULL, 'No reviews', AVG(r.review_rate)) `rates`,
            CONCAT(u.user_name, ' ', u.user_last_name) `instructor`,
            SUM(TIME_TO_SEC(v.video_duration)) / 3600.0 AS `duration`,
            COUNT(DISTINCT e.enrollment_id) AS `enrollments`
        FROM
            `courses` AS c
        INNER JOIN
            levels AS l
        ON
            c.course_id = l.course_id
        INNER JOIN
            lessons AS le
        ON
            l.level_id = le.level_id
        LEFT JOIN
            videos AS v
        ON
            le.video_id = v.video_id
        LEFT JOIN
            reviews AS r
        ON
            c.course_id = r.course_id
        INNER JOIN
            users AS u
        ON
            c.instructor_id = u.user_id
        LEFT JOIN
            enrollments AS e
        ON
            c.course_id = e.course_id
        WHERE
            c.course_active = TRUE
            AND c.course_approved = TRUE
        GROUP BY
            c.course_id
        ORDER BY
            IF(AVG(r.review_rate) IS NULL, 0, AVG(r.review_rate)) DESC
    SQL;

    private const FIND_ALL_ORDER_BY_ENROLLMENTS = <<<'SQL'
        SELECT
            c.course_id AS `id`,
            c.course_title AS `title`,
            c.course_description AS `description`,
            c.course_price AS `price`,
            c.course_image_id AS `imageId`,
            c.instructor_id AS `instructorId`,
            c.course_approved AS `approved`,
            c.course_approved_by AS `approvedBy`,
            c.course_created_at AS `createdAt`,
            c.course_modified_at AS `modifiedAt`,
            c.course_active AS `active`,
            COUNT(DISTINCT l.level_id) AS `levels`,
            IF(AVG(r.review_rate) IS NULL, 'No reviews', AVG(r.review_rate)) `rates`,
            CONCAT(u.user_name, ' ', u.user_last_name) `instructor`,
            SUM(TIME_TO_SEC(v.video_duration)) / 3600.0 AS `duration`,
            COUNT(DISTINCT e.enrollment_id) AS `enrollments`
        FROM
            `courses` AS c
        INNER JOIN
            levels AS l
        ON
            c.course_id = l.course_id
        INNER JOIN
            lessons AS le
        ON
            l.level_id = le.level_id
        LEFT JOIN
            videos AS v
        ON
            le.video_id = v.video_id
        LEFT JOIN
            reviews AS r
        ON
            c.course_id = r.course_id
        INNER JOIN
            users AS u
        ON
            c.instructor_id = u.user_id
        LEFT JOIN
            enrollments AS e
        ON
            c.course_id = e.course_id
        WHERE
            c.course_active = TRUE
            AND c.course_approved = TRUE
        GROUP BY
            c.course_id
        ORDER BY
            COUNT(DISTINCT e.enrollment_id) DESC
    SQL;

    private const INSTRUCTOR_COURSES_FIND_ALL_BY_INSTRUCTOR_ID = <<<'SQL'
        SELECT
            `id`,
            `title`,
            `imageId`,
            `enrollments`,
            `amount`,
            `averageLevel`,
            `instructorId`
        FROM
            `instructor_courses`
        WHERE
            `instructorId` = :instructor_id
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

    public function findAllOrderByCreatedAt(): array {
        return DB::executeReader($this::FIND_ALL_ORDER_BY_CREATED_AT, []);
    }

    public function findAllOrderByRates(): array {
        return DB::executeReader($this::FIND_ALL_ORDER_BY_RATES, []);
    }

    public function findAllOrderByEnrollments(): array {
        return DB::executeReader($this::FIND_ALL_ORDER_BY_ENROLLMENTS, []);
    }

    public function instructorCoursesFindAllByInstructorId(int $instructorId): array {
        $parameters = [
            "instructor_id" => $instructorId
        ];
        return DB::executeReader($this::INSTRUCTOR_COURSES_FIND_ALL_BY_INSTRUCTOR_ID, 
        $parameters);
    }
}
