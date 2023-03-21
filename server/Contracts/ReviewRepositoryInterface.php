<?php

namespace Cursotopia\Contracts;

use Cursotopia\Entities\Review;

interface ReviewRepositoryInterface {
    public function create(Review $review): int;
    public function update(Review $review): int;
    public function delete(int $id): int;
    public function findOneById(int $id): array;
    public function findAllByCourse(int $courseId): array;
}
