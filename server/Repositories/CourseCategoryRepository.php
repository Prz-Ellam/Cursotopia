<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\CourseCategory;

class CourseCategoryRepository extends DB {
    private const CREATE = <<<'SQL'
        CALL `course_category_create`(
            :course_id,
            :category_id,
            @course_category_id
        )
    SQL;

    private const DELETE_BY_COURSE = <<<'SQL'
        CALL `course_category_delete_by_course`(:course_id) 
    SQL;

    public function create(CourseCategory $courseCategory): int {
        $parameters = [
            "course_id" => $courseCategory->getCourseId(),
            "category_id" => $courseCategory->getCategoryId()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function deleteByCourse(?int $courseId): int {
        $parameters = [
            "course_id" => $courseId
        ];
        return $this->executeNonQuery($this::DELETE_BY_COURSE, $parameters);
    }
}
