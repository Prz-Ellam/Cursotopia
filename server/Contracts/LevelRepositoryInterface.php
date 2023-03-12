<?php

namespace Cursotopia\Contracts;

use Cursotopia\Entities\Level;

interface LevelRepositoryInterface {
    public function create(Level $level): int;
    public function update(Level $level): int;
    public function delete(int $id): int;
    public function findOne(int $id): array;
}
