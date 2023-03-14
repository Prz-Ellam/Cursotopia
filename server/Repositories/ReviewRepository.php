<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Contracts\ReviewRepositoryInterface;
use Cursotopia\Entities\Review;

class ReviewRepository implements ReviewRepositoryInterface {
    private const CREATE = <<<'SQL'
        INSERT INTO reviews(
            review_message,
            review_rate,
            course_id,
            user_id
        )
        SELECT
            :message,
            :rate,
            :course_id,
            :user_id
        FROM
            dual
        WHERE
            :message IS NOT NULL
            AND :rate IS NOT NULL
            AND :course_id IS NOT NULL
            AND :user_id IS NOT NULL
    SQL;

    private const UPDATE = <<<'SQL'
        UPDATE
            reviews
        SET
            review_message = IFNULL(:message, review_message),
            review_rate = IFNULL(:rate, review_rate),
            review_active = IFNULL(:active, review_active)
        WHERE
            review_id = :id
    SQL;

    private const FIND_ALL_BY_COURSE = <<<'SQL'
        SELECT
            r.review_id AS `id`,
            r.review_message AS `message`,
            r.review_rate AS `rate`,
            r.course_id AS `courseId`,
            r.user_id AS `userId`,
            r.review_created_at AS `createdAt`,
            r.review_modified_at AS `modifiedAt`,
            r.review_active AS `active`,
            CONCAT(u.user_name, ' ', u.user_last_name) AS `userName`,
            u.profile_picture AS `profilePicture`
        FROM
            reviews AS r
        INNER JOIN
            users AS u
        ON
            r.user_id = u.user_id
        WHERE
            course_id = :course_id
        ORDER BY
            review_created_at DESC;
    SQL;
    
    public function create(Review $review): int {
        $parameters = [
            "message" => $review->getMessage(),
            "rate" => $review->getRate(),
            "course_id" => $review->getCourseId(),
            "user_id" => $review->getUserId()
        ];
        return DB::executeNonQuery($this::CREATE, $parameters);
    }

    public function update(Review $review): int {
        $parameters = [
            "id" => $review->getId(),
            "message" => $review->getMessage(),
            "rate" => $review->getRate(),
            "active" => $review->getActive()
        ];
        return DB::executeNonQuery($this::UPDATE, $parameters);
    }

    public function delete(int $id): int {
        return 1;
    }

    public function findOneById(int $id): array {
        return [];
    }

    public function findAllByCourse(int $courseId): array {
        $parameters = [
            "course_id" => $courseId
        ];
        return DB::executeReader($this::FIND_ALL_BY_COURSE, $parameters);
    }
}
