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
}
