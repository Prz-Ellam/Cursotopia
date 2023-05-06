<?php

namespace Cursotopia\Models;

use Cursotopia\Entities\Course;
use Cursotopia\Repositories\CourseRepository;
use Cursotopia\ValueObjects\EntityState;

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
    private ?bool $isComplete = null;
    private ?string $approvedAt = null;
    private EntityState $entityState;
    private CourseRepository $courseRepository;

    public function __construct(?array $object = null) {
        $this->id = $object["id"] ?? null;
        $this->title = $object["title"] ?? null;
        $this->description = $object["description"] ?? null;
        $this->price = $object["price"] ?? null;
        $this->imageId = $object["imageId"] ?? null;
        $this->instructorId = $object["instructorId"] ?? null;
        $this->isComplete = $object["isComplete"] ?? null;
        $this->approved = $object["approved"] ?? null;
        $this->approvedBy = $object["approvedBy"] ?? null;
        $this->approvedAt = $object["approvedAt"] ?? null;
        $this->createdAt = $object["createdAt"] ?? null;
        $this->modifiedAt = $object["modifiedAt"] ?? null;
        $this->active = $object["active"] ?? null;

        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
        $this->courseRepository = new CourseRepository();
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

    public static function deny(int $courseId) {
        $courseRepository = new CourseRepository();
        $rowsAffected = $courseRepository->delete($courseId);
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

    public function save(): bool {
        $course = new Course();
        $course
            ->setId($this->id)
            ->setTitle($this->title)
            ->setDescription($this->description)
            ->setPrice($this->price)
            ->setImageId($this->imageId)
            ->setInstructorId($this->instructorId)
            ->setIsComplete($this->isComplete)
            ->setApproved($this->approved)
            ->setApprovedBy($this->approvedBy)
            ->setApprovedAt($this->approvedAt)
            ->setCreatedAt($this->createdAt)
            ->setModifiedAt($this->modifiedAt)
            ->setActive($this->active);
            
        $rowsAffected = 0;
        switch ($this->entityState) {
            case EntityState::CREATE: {
                $rowsAffected = $this->courseRepository->create($course);
                if ($rowsAffected) {
                    $this->id = intval($this->courseRepository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = $this->courseRepository->update($course);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }

    public function toObject() : array {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array {
        return array_keys(get_class_vars(self::class));
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of instructorId
     */ 
    public function getInstructorId()
    {
        return $this->instructorId;
    }

    /**
     * Set the value of instructorId
     *
     * @return  self
     */ 
    public function setInstructorId($instructorId)
    {
        $this->instructorId = $instructorId;

        return $this;
    }
}
