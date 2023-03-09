<?php

namespace Cursotopia\Entities;

class Enrollment {
    private int $id;
    private int $courseId;
    private int $studentId;
    private bool $isFinished;
    private string $enrollDate;
    private string $finishDate;
    private string $certificateUid;
    private float $amount;
    private int $paymentMethodId;
    private string $lastTimeChecked;
    private string $createdAt;
    private string $modifiedAt;
    private bool $active;
}
