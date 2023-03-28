<?php

namespace Cursotopia\Contracts;

use Cursotopia\Entities\User;

interface UserRepositoryInterface {
    public function create(User $user);
    public function update(User $user);
    public function delete();
    public function lastInsertId2();
}
