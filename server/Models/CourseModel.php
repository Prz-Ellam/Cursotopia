<?php

namespace Cursotopia\Models;

use Cursotopia\Repositories\CourseRepository;

class CourseModel {
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?float $price = null;
    private ?int $imageId = null;
    private ?int $instructorId = null;
    private ?bool $approved = null;
    private ?int $approvedBy = null;
    private ?string $createdAt = null;
    private ?string $modifiedAt = null;
    private ?bool $active = null;

    public function __construct(?array $object = null) {
        $this->id = $object["id"] ?? null;
        $this->title = $object["title"] ?? null;
        $this->description = $object["description"] ?? null;
        $this->price = $object["price"] ?? null;
        $this->imageId = $object["imageId"] ?? null;
        $this->instructorId = $object["instructorId"] ?? null;
        $this->approved = $object["approved"] ?? null;
        $this->approvedBy = $object["approvedBy"] ?? null;
        $this->createdAt = $object["createdAt"] ?? null;
        $this->modifiedAt = $object["modifiedAt"] ?? null;
        $this->active = $object["active"] ?? null;
    }
    // Obtener los mas vendidos
    // Obtener los mas recientes
    // Obtener los mejor calificados

    // No todas las propiedades de los modelos son de la entidad per se
    public static function findById(int $id): ?CourseModel {
        $courseRepository = new CourseRepository();
        $courseObject = $courseRepository->findById($id);
        if (!$courseObject) {
            return null;
        }
        return new CourseModel($courseObject);
    }

    public static function confirm(int $id) {
        $courseRepository = new CourseRepository();
        $rowsAffected = $courseRepository->confirm($id);
        return ($rowsAffected > 0) ? true : false;
    }

    public static function approve(int $courseId, int $adminId, bool $approve) {
        $courseRepository = new CourseRepository();
        $rowsAffected = $courseRepository->approve($courseId, $adminId, $approve);
        return ($rowsAffected > 0) ? true : false;
    }

    public static function findByNotApproved() {
        $courseRepository = new CourseRepository();
        return $courseRepository->findByNotApproved();
    }

    public static function findSearch(?string $title, ?int $instructorId, ?int $categoryId,
    ?string $from = null, ?string $to = null, int $limit = 100, int $offset = 0): array {
        $courseRepository = new CourseRepository();
        return $courseRepository->courseSearch($title, $instructorId, $categoryId, $from, $to, $limit, $offset);
    }

    public static function findSearchTotal(?string $title, ?int $instructorId, ?int $categoryId,
    ?string $from = null, ?string $to = null, int $limit = 100, int $offset = 0): int {
        $courseRepository = new CourseRepository();
        $obj = $courseRepository->courseSearchTotal($title, $instructorId, $categoryId, $from, $to, $limit, $offset);
        return $obj["total"];
    }

    public static function salesReport(int $instructorId, ?int $categoryId = null,
    ?string $from = null, ?string $to = null, ?int $active = null,
    int $limit = 100, int $offset = 0): array {
        $courseRepository = new CourseRepository();
        return $courseRepository->courseSalesReport($instructorId, $categoryId, $from, $to, $active, $limit, $offset);
    }    
    
    public static function salesReportTotal(int $instructorId, ?int $categoryId = null,
    ?string $from = null, ?string $to = null, ?int $active = null): int {
        $courseRepository = new CourseRepository();
        $obj = $courseRepository->courseSalesReportTotal($instructorId, $categoryId, $from, $to, $active);
        return $obj["total"];
    }

    public static function kardexReport(int $studentId, ?int $categoryId = null,
    ?string $from = null, ?string $to = null, ?int $complete = null, ?int $active = null,
    int $limit = 100, int $offset = 0): array {
        $courseRepository = new CourseRepository();
        return $courseRepository->kardexReport($studentId, $from, $to, $categoryId, $complete, $active, $limit, $offset);
    }

    public static function kardexReportTotal(int $studentId, ?int $categoryId = null,
    ?string $from = null, ?string $to = null, ?int $complete = null, ?int $active = null): int {
        $courseRepository = new CourseRepository();
        $obj = $courseRepository->kardexReportTotal($studentId, $from, $to, $categoryId, $complete, $active);
        return $obj["total"];
    }

    public static function enrollmentsReport(int $courseId, ?string $from = null,
    ?string $to = null, int $limit = 100, int $offset = 0): array {
        $courseRepository = new CourseRepository();
        return $courseRepository->courseEnrollmentsReport($courseId, $from, $to, $limit, $offset);
    }

    public static function enrollmentsReportTotal(int $courseId, ?string $from = null,
    ?string $to = null): int {
        $courseRepository = new CourseRepository();
        $obj = $courseRepository->courseEnrollmentsReportTotal($courseId, $from, $to);
        return $obj["total"];
    }

    public function toObject() : array {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array {
        return array_keys(get_class_vars(self::class));
    }
}
