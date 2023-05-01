<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\CourseCategory;

class CourseCategoryRepository extends DB {
    private const CREATE = <<<'SQL'
        INSERT INTO course_category(
            `course_id`,
            `category_id`
        )
        SELECT
            :course_id,
            :category_id
        WHERE
            :course_id IS NOT NULL
            AND :category_id IS NOT NULL
    SQL;

    private const DELETE_BY_COURSE = <<<'SQL'
        CALL `course_category_delete_by_course`(:course_id) 
    SQL;

    public function create(CourseCategory $courseCategory): int {
        $parameters = [
            "course_id" => $courseCategory->getCourseId(),
            "category_id" => $courseCategory->getCategoryId()
        ];
        return DB::executeNonQuery($this::CREATE, $parameters);
    }

    public function deleteByCourse(?int $courseId): bool {
        $parameters = [
            "course_id" => $courseId
        ];
        return $this->executeNonQuery($this::DELETE_BY_COURSE, $parameters);
    }
}
