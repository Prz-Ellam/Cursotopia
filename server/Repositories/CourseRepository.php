<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;

class CourseRepository {
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

    public function courseDetailsfindOneById(int $id): array {
        $parameters = [
            "id" => $id
        ];
        return DB::executeOneReader($this::COURSE_DETAILS_FIND_ONE, $parameters);
    }
}
