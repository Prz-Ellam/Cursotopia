<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Review;

class ReviewRepository {
    private const CREATE = <<<'SQL'
        CALL `review_create`(
            :message,
            :rate,
            :course_id,
            :user_id
        )
    SQL;

    private const UPDATE = <<<'SQL'
        CALL `sp_update_review`( 
            :id, 
            :message, 
            :rate, 
            :active
        );
    SQL;

    private const FIND_ALL_BY_COURSE = <<<'SQL'
        CALL `sp_get_course_reviews`(
            :course_id
        );
    SQL;

    private const FIND_ONE_BY_COURSE_AND_USER_ID = <<<'SQL'
        CALL `sp_get_review_by_course_and_user`(
            :courseId, 
            :userId
        );
    SQL;

    private const FIND_BY_COURSE = <<<'SQL'
        CALL `get_course_reviews`
        (
            :courseId,
            :pageNum, 
            :pageSize
        );
    SQL;

    private const FIND_ONE = <<<'SQL'
        CALL `sp_get_review_by_id`(
            :id
        );
    SQL;

    private const DELETE = <<<'SQL'
        CALL `sp_deactivate_review`(
            :id
        );
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

    public function findOneById(int $id): array {
        return [];
    }

    public function findAllByCourse(int $courseId): array {
        $parameters = [
            "course_id" => $courseId
        ];
        return DB::executeReader($this::FIND_ALL_BY_COURSE, $parameters);
    }

    public function findByCourse(int $courseId,int $pageNum,int $pageSize): array {
        $parameters = [
            "courseId" => $courseId,
            "pageNum" => $pageNum,
            "pageSize" => $pageSize
        ];
        return DB::executeReader($this::FIND_BY_COURSE, $parameters);
    }

    public function findOneByCourseAndUserId(int $courseId, int $userId) {
        $parameters =[
            "courseId" => $courseId,
            "userId" => $userId
        ];
        return DB::executeOneReader($this::FIND_ONE_BY_COURSE_AND_USER_ID, $parameters) ?? null;
    }

    public function findById(int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return DB::executeOneReader($this::FIND_ONE, $parameters);
    }

    public function delete(int $id): int {
        $parameters = [
            "id" => $id
        ];
        return DB::executeNonQuery($this::DELETE, $parameters);
    }
}
