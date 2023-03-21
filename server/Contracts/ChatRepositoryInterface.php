<?php

namespace Cursotopia\Contracts;

interface ChatRepositoryInterface {
    public function findAllByUser(int $userId): array;
}
