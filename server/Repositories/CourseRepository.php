<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Course;

class CourseRepository extends DB implements Repository {
    private const CREATE = <<<'SQL'
        CALL `course_create`(
            :title,
            :description,
            :price,
            :image_id,
            :instructor_id,
            @course_id
        )
    SQL;

    private const UPDATE = <<<'SQL'
        CALL `course_update`(
            :course_id,
            :course_title,
            :course_description,
            :course_price,
            :course_image_id,
            :instructor_id,
            :course_is_complete,
            :course_approved,
            :course_approved_by,
            :course_approved_at,
            :course_created_at,
            :course_modified_at,
            :course_active
        ) 
    SQL;

    private const FIND_BY_ID = <<<'SQL'
        CALL `course_find_by_id`(:course_id)
    SQL;

    private const FIND_BY_NOT_APPROVED = <<<'SQL'
        CALL `course_find_by_not_approved`()
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
            `duration` AS `duration`,
            `enrollments` AS `students`,
            `levelFree`
        FROM
            `course_details`
        WHERE
            `id` = :id
    SQL;

    // Home
    private const FIND_ALL_ORDER_BY_CREATED_AT = <<<'SQL'
        CALL `course_find_all_order_by_created_by`()
    SQL;

    private const FIND_ALL_ORDER_BY_RATES = <<<'SQL'
        CALL `course_find_all_order_by_rates`()
    SQL;

    private const FIND_ALL_ORDER_BY_ENROLLMENTS = <<<'SQL'
        CALL `course_find_all_order_by_enrollments`()
    SQL;

    // Reportes
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
            :to
        )
    SQL;

    private const INSTRUCTOR_COURSES_SEEN_BY_OTHER = <<<'SQL'
        CALL `instructor_courses_seen_by_others_report`(
            :instructor_id, 
            :limit, 
            :offset
        )
    SQL;

    private const INSTRUCTOR_COURSES_SEEN_BY_OTHER_TOTAL = <<<'SQL'
        CALL `instructor_courses_seen_by_others_report_total`(:instructor_id)
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
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function update(Course $course): int {
        $parameters = [
            "course_id" => $course->getId(),
            "course_title" => $course->getTitle(),
            "course_description" => $course->getDescription(),
            "course_price" => $course->getPrice(),
            "course_image_id" => $course->getImageId(),
            "instructor_id" => $course->getInstructorId(),
            "course_is_complete" => $course->getIsComplete(),
            "course_approved" => $course->isApproved(),
            "course_approved_by" => $course->getApprovedBy(),
            "course_approved_at" => $course->getApprovedAt(),
            "course_created_at" => $course->getCreatedAt(),
            "course_modified_at" => $course->getModifiedAt(),
            "course_active" => $course->isActive()
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }

    public function findById(?int $id): ?array {
        $parameters = [
            "course_id" => $id
        ];
        return $this::executeOneReader($this::FIND_BY_ID, $parameters);
    }

    public function courseDetailsfindOneById(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::COURSE_DETAILS_FIND_ONE, $parameters);
    }

    public function findAllOrderByCreatedAt(): ?array {
        return $this::executeReader($this::FIND_ALL_ORDER_BY_CREATED_AT, []);
    }

    public function findAllOrderByRates(): ?array {
        return $this::executeReader($this::FIND_ALL_ORDER_BY_RATES, []);
    }

    public function findAllOrderByEnrollments(): ?array {
        return $this::executeReader($this::FIND_ALL_ORDER_BY_ENROLLMENTS, []);
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
        return $this::executeReader($this::COURSE_SALES_REPORT,  $parameters);
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
        return $this::executeOneReader($this::COURSE_SALES_REPORT_TOTAL,  $parameters);
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
        return $this::executeReader($this::KARDEX_REPORT, $parameters);
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
        return $this::executeOneReader($this::KARDEX_REPORT_TOTAL, $parameters);
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
        return $this::executeReader($this::COURSE_ENROLLMENTS_REPORT, $parameters);
    }

    public function courseEnrollmentsReportTotal(int $courseId, ?string $from = null, 
        ?string $to = null): array {
        $parameters = [
            "course_id" => $courseId,
            "from" => $from,
            "to" => $to
        ];
        return $this::executeOneReader($this::COURSE_ENROLLMENTS_REPORT_TOTAL, $parameters);
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
        return $this::executeReader($this::COURSE_SEARCH, $parameters);
    }

    public function courseSearchTotal(?string $title, ?int $instructorId, ?int $categoryId,
    ?string $from = null, ?string $to = null, int $limit = 100, int $offset = 0): array {
        $parameters = [
            "title" => $title,
            "instructor_id" => $instructorId,
            "category_id" => $categoryId,
            "from" => $from,
            "to" => $to
        ];
        return $this::executeOneReader($this::COURSE_SEARCH_TOTAL, $parameters);
    }

    public function instructorTotalRevenueReport(int $instructorId): array {
        $parameters = [
            "instructor_id" => $instructorId
        ];
        return $this::executeReader($this::INSTRUCTOR_TOTAL_REVENUE_REPORT, $parameters);
    }

    public function findByNotApproved(): ?array {
        return $this::executeReader($this::FIND_BY_NOT_APPROVED, []);
    }

    public function instructorCoursesSeenByOtherReport(int $instructorId, int $limit = 100, int $offset = 0): array {
        $parameters = [
            "instructor_id" => $instructorId,
            "limit" => $limit,
            "offset" => $offset
        ];
        return $this::executeReader($this::INSTRUCTOR_COURSES_SEEN_BY_OTHER, $parameters);
    }
    
    public function instructorCoursesSeenByOtherTotal(int $instructorId): array {
        $parameters = [
            "instructor_id" => $instructorId
        ];
        return $this::executeOneReader($this::INSTRUCTOR_COURSES_SEEN_BY_OTHER_TOTAL, $parameters);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @course_id AS courseId", [])["courseId"];
    }
}
