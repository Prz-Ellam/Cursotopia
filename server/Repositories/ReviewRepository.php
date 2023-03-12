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
            user_id,
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
        return [];
    }
}
