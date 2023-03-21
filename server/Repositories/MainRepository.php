<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;

class MainRepository {
    private const HOME_STATS = <<<'SQL'
        SELECT
            (SELECT COUNT(user_id) FROM users WHERE user_role = 2) AS `instructors`,
            (SELECT COUNT(user_id) FROM users WHERE user_role = 3) AS `students`,
            (SELECT COUNT(course_id) FROM courses WHERE course_active = TRUE 
                AND course_approved = TRUE) AS `courses`
    SQL;

    public function homeStats() {
        return DB::executeOneReader($this::HOME_STATS, []);
    }
}