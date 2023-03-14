<?php

namespace Cursotopia\Contracts;

use Cursotopia\Entities\Enrollment;

interface EnrollmentRepositoryInterface {
    public function create(Enrollment $enrollment): int;
}
