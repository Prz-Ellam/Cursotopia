<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\CourseCategory;

class CourseCategoryRepository {
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

    public function create(CourseCategory $courseCategory): int {
        $parameters = [
            "course_id" => $courseCategory->getCourseId(),
            "category_id" => $courseCategory->getCategoryId()
        ];
        return DB::executeNonQuery($this::CREATE, $parameters);
    }
}
