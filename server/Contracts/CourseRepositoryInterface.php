<?php

namespace Cursotopia\Contracts;

use Cursotopia\Entities\Course;

interface CourseRepositoryInterface {
    public function create(Course $course): int;
    public function update(Course $course): int;
    public function delete(Course $course): int;
    public function findOneById(int $id): array;
    public function findAll(): array;

    public function findAllOrderByCreatedAt(): array;
    public function findAllOrderByRate(): array;
    public function findAllOrderByEnrollments(): array;

    public function findAllByStudentEnrollments(int $studentId): array;
    public function findAllByInstructorId(int $instructorId): array;
}
