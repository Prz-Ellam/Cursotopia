<?php

namespace Cursotopia\Contracts;

use Cursotopia\Entities\Lesson;

interface LessonRepositoryInterface {
    public function create(Lesson $lesson): int;
    public function update(Lesson $lesson): int;
    public function delete(int $id): int;
    public function findById(?int $id): ?array;
}
