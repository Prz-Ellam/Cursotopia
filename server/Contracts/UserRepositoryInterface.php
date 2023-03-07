<?php

namespace Cursotopia\Contracts;

use Cursotopia\Entities\User;

interface UserRepositoryInterface {
    public function create(User $user);
    public function update();
    public function delete();
}
