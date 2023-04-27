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

    private const CONFIRM = <<<'SQL'
        UPDATE
            `courses`
        SET
            `course_is_complete` = TRUE
        WHERE
            `course_id` = :id;
    SQL;

    private const DELETE = <<<'SQL'
        UPDATE
            courses
        SET
            course_active = FALSE
        WHERE
            course_id = :course_id
    SQL;

    private const APPROVE = <<<'SQL'
        UPDATE
            `courses`
        SET
            `course_approved` = :approve,
            `course_approved_by` = :admin_id,
            `course_approved_at` = NOW()
        WHERE
            `course_id` = :course_id
    SQL;

    private const FIND_ONE = <<<'SQL'
        SELECT
            `course_id` AS `id`,
            `course_title` AS `title`,
            `course_description` AS `description`,
            `course_price` AS `price`,
            `course_image_id` AS `imageId`,
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

    private const FIND_BY_NOT_APPROVED = <<<'SQL'
        SELECT
            c.`course_id` AS `id`,
            c.`course_title` AS `title`,
            c.`course_description` AS `description`,
            c.`course_price` AS `price`,
            c.`course_image_id` AS `imageId`,
            CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `instructor`,
            c.`course_approved` AS `approved`,
            c.`course_approved_by` AS `approvedBy`,
            c.`course_created_at` AS `createdAt`,
            c.`course_modified_at` AS `modifiedAt`,
            c.`course_active` AS `active`
        FROM
            `courses` AS c
        INNER JOIN  
            `users` AS u
        ON
            c.`instructor_id` = u.`user_id`
        WHERE
            `course_approved` = FALSE
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

    private const FIND_ALL_ORDER_BY_CREATED_AT = <<<'SQL'
        SELECT
            `course_id` AS `id`,
            `course_title` AS `title`,
            `course_price` AS `price`,
            `course_image_id` AS `imageId`,
            `instructor_name` AS `instructorName`,
            `levels`,
            `rate`,
            `video_duration` AS `videoDuration`
        FROM
            `course_card`
        WHERE
            `course_active` = TRUE
            AND `course_approved` = TRUE
            AND `course_is_complete` = TRUE
        ORDER BY
            `course_created_at` DESC
        LIMIT
            15
    SQL;

    private const FIND_ALL_ORDER_BY_RATES = <<<'SQL'
        SELECT
            `course_id` AS `id`,
            `course_title` AS `title`,
            `course_price` AS `price`,
            `course_image_id` AS `imageId`,
            `instructor_name` AS `instructorName`,
            `levels`,
            `rate`,
            `video_duration` AS `videoDuration`
        FROM
            `course_card`
        WHERE
            `course_active` = TRUE
            AND `course_approved` = TRUE
            AND `course_is_complete` = TRUE
        ORDER BY
            `rate` DESC
        LIMIT
            15
    SQL;

    private const FIND_ALL_ORDER_BY_ENROLLMENTS = <<<'SQL'
        SELECT
            cc.`course_id` AS `id`,
            cc.`course_title` AS `title`,
            cc.`course_price` AS `price`,
            cc.`course_image_id` AS `imageId`,
            cc.`instructor_name` AS `instructorName`,
            cc.`levels`,
            cc.`rate`,
            cc.`video_duration` AS `videoDuration`
        FROM
            `course_card` AS cc
        LEFT JOIN
            `enrollments` AS e
        ON
            cc.`course_id` = e.`course_id`
        WHERE
            cc.`course_active` = TRUE
            AND cc.`course_approved` = TRUE
            AND cc.`course_is_complete` = TRUE
        GROUP BY
            cc.`course_id`
        ORDER BY
            COUNT(e.`enrollment_id`) DESC
        LIMIT
            15
    SQL;

    private const COURSE_SALES_REPORT = <<<'SQL'
        CALL `course_sales_report`(
            :instructor_id, 
            :category_id, 
            :from, 
            :to, 
            :active,
            :limit, 
            :offset
        )
    SQL;

    private const COURSE_SALES_REPORT_TOTAL = <<<'SQL'
        CALL `course_sales_report_total`(
            :instructor_id,
            :category_id,
            :from,
            :to,
            :active
        )
    SQL;

    private const KARDEX_REPORT = <<<'SQL'
        CALL `kardex_report`(
            :student_id,
            :from,
            :to,
            :category_id,
            :complete,
            :active,
            :limit,
            :offset
        )
    SQL;

    private const KARDEX_REPORT_TOTAL = <<<'SQL'
        CALL `kardex_report_total`(
            :student_id,
            :from,
            :to,
            :category_id,
            :complete,
            :active
        )
    SQL;

    private const COURSE_ENROLLMENTS_REPORT = <<<'SQL'
        CALL `course_enrollments_report`(
            :course_id, 
            :from, 
            :to, 
            :limit, 
            :offset
        )
    SQL;

    private const COURSE_ENROLLMENTS_REPORT_TOTAL = <<<'SQL'
        CALL `course_enrollments_report_total`(
            :course_id, 
            :from, 
            :to
        );
    SQL;

    private const COURSE_SEARCH = <<<'SQL'
        CALL `course_search`(
            :title,
            :instructor_id,
            :category_id,
            :from,
            :to,
            :limit,
            :offset
        )
    SQL;

    private const COURSE_SEARCH_TOTAL = <<<'SQL'
        CALL `course_search_total`(
            :title,
            :instructor_id,
            :category_id,
            :from,
            :to,
            :limit,
            :offset
        )
    SQL;

    private const INSTRUCTOR_TOTAL_REVENUE_REPORT = <<<'SQL'
        CALL `instructor_total_revenue_report`(
            :instructor_id
        )
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

    public function findById(int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return DB::executeOneReader($this::FIND_ONE, $parameters);
    }

    public function confirm(int $id): bool {
        $parameters = [
            "id" => $id
        ];
        return DB::executeNonQuery($this::CONFIRM, $parameters);
    }

    public function courseDetailsfindOneById(int $id): array {
        $parameters = [
            "id" => $id
        ];
        return DB::executeOneReader($this::COURSE_DETAILS_FIND_ONE, $parameters);
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

    public function courseSalesReport(int $instructorId, 
        ?int $categoryId = null, ?string $from = null, ?string $to = null, ?int $active = 0, 
        int $limit = 100, int $offset = 0): array {
        $parameters = [
            "instructor_id" => $instructorId,
            "category_id" => $categoryId,
            "from" => $from,
            "to" => $to,
            "active" => $active,
            "limit" => $limit,
            "offset" => $offset
        ];
        return DB::executeReader($this::COURSE_SALES_REPORT,  $parameters);
    }

    public function courseSalesReportTotal(int $instructorId, ?int $categoryId = null,
        ?string $from = null, ?string $to = null, ?int $active = 0) {
        $parameters = [
            "instructor_id" => $instructorId,
            "category_id" => $categoryId,
            "from" => $from,
            "to" => $to,
            "active" => $active
        ];
        return DB::executeOneReader($this::COURSE_SALES_REPORT_TOTAL,  $parameters);
    }

    public function kardexReport(int $studentId, 
        ?string $from = null, ?string $to = null, ?int $categoryId = null, ?int $complete = null, ?int $active = 0, 
        int $limit = 100, int $offset = 0): array {
        $parameters = [
            "student_id" => $studentId,
            "from" => $from,
            "to" => $to,
            "category_id" => $categoryId,
            "complete" => $complete,
            "active" => $active,
            "limit" => $limit,
            "offset" => $offset
        ];
        return DB::executeReader($this::KARDEX_REPORT, $parameters);
    }

    public function kardexReportTotal(int $studentId, 
        ?string $from = null, ?string $to = null, ?int $categoryId = null, ?int $complete = null, ?int $active = 0): array {
        $parameters = [
            "student_id" => $studentId,
            "from" => $from,
            "to" => $to,
            "category_id" => $categoryId,
            "complete" => $complete,
            "active" => $active
        ];
        return DB::executeOneReader($this::KARDEX_REPORT_TOTAL, $parameters);
    }

    public function courseEnrollmentsReport(int $courseId, ?string $from = null, 
        ?string $to = null, int $limit = 100, int $offset = 0): array {
        $parameters = [
            "course_id" => $courseId,
            "from" => $from,
            "to" => $to,
            "limit" => $limit,
            "offset" => $offset
        ];
        return DB::executeReader($this::COURSE_ENROLLMENTS_REPORT, $parameters);
    }

    public function courseEnrollmentsReportTotal(int $courseId, ?string $from = null, 
        ?string $to = null): array {
        $parameters = [
            "course_id" => $courseId,
            "from" => $from,
            "to" => $to
        ];
        return DB::executeOneReader($this::COURSE_ENROLLMENTS_REPORT_TOTAL, $parameters);
    }

    public function courseSearch(?string $title, ?int $instructorId, ?int $categoryId,
    ?string $from = null, ?string $to = null, int $limit = 100, int $offset = 0): array {
        $parameters = [
            "title" => $title,
            "instructor_id" => $instructorId,
            "category_id" => $categoryId,
            "from" => $from,
            "to" => $to,
            "limit" => $limit,
            "offset" => $offset
        ];
        return DB::executeReader($this::COURSE_SEARCH, $parameters);
    }

    public function courseSearchTotal(?string $title, ?int $instructorId, ?int $categoryId,
    ?string $from = null, ?string $to = null, int $limit = 100, int $offset = 0): array {
        $parameters = [
            "title" => $title,
            "instructor_id" => $instructorId,
            "category_id" => $categoryId,
            "from" => $from,
            "to" => $to,
            "limit" => $limit,
            "offset" => $offset
        ];
        return DB::executeOneReader($this::COURSE_SEARCH_TOTAL, $parameters);
    }

    public function instructorTotalRevenueReport(int $instructorId): array {
        $parameters = [
            "instructor_id" => $instructorId
        ];
        return DB::executeReader($this::INSTRUCTOR_TOTAL_REVENUE_REPORT, $parameters);
    }

    public function findByNotApproved(): array {
        return DB::executeReader($this::FIND_BY_NOT_APPROVED, []);
    }

    public function approve(int $courseId, int $adminId, bool $approve): int {
        $parameters = [
            "course_id" => $courseId,
            "admin_id" => $adminId,
            "approve" => $approve
        ];
        return DB::executeNonQuery($this::APPROVE, $parameters);
    }

    public function delete(int $courseId): int {
        $parameters = [
            "course_id" => $courseId
        ];
        return DB::executeNonQuery($this::DELETE, $parameters);
    }
}
