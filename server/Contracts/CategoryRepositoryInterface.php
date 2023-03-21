<?php

namespace Cursotopia\Contracts;

use Cursotopia\Entities\Category;

interface CategoryRepositoryInterface {
    public function create(Category $category): int|string;
    public function update(Category $category): int;
    // public function findOneById(int $id): array;
    public function findAllByCourse(int $courseId): array;
}
