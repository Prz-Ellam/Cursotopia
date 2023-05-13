<?php

namespace Cursotopia\Models;

use Cursotopia\Entities\Course;
use Cursotopia\Repositories\CourseRepository;
use Cursotopia\Repositories\Repository;
use Cursotopia\ValueObjects\EntityState;
use JsonSerializable;

class CourseModel implements JsonSerializable {
    private static ?CourseRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];

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

    public function __construct(?array $data = null) {
        $properties = get_object_vars($this);
        foreach ($properties as $name => $value) {
            if ($value instanceof Repository || $value instanceof EntityState) {
                continue;
            }

            if ($name == '_ignores') {
                continue;
            }

            $this->$name = (isset($data[$name])) ? $data[$name] : null;
        }

        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        $this->entityState = (is_null($this->id)) ? EntityState::CREATE : EntityState::UPDATE;
        return $this;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(?string $title): self {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(?float $price): self {
        $this->price = $price;
        return $this;
    }

    public function getImageId(): ?int {
        return $this->imageId;
    }

    public function setImageId(?int $imageId): self {
        $this->imageId = $imageId;
        return $this;
    }

    public function getInstructorId(): ?int {
        return $this->instructorId;
    }

    public function setInstructorId(?int $instructorId): self {
        $this->instructorId = $instructorId;
        return $this;
    }

    public function isApproved(): ?bool {
        return $this->approved;
    }

    public function setApproved(?bool $approved): self {
        $this->approved = $approved;
        return $this;
    }

    public function getApprovedBy(): ?int {
        return $this->approvedBy;
    }

    public function setApprovedBy(?int $approvedBy): self {
        $this->approvedBy = $approvedBy;
        return $this;
    }

    public function getIsComplete(): ?bool {
        return $this->isComplete;
    }

    public function setIsComplete(?bool $isComplete): self {
        $this->isComplete = $isComplete;
        return $this;
    }

    public function getApprovedAt(): ?string {
        return $this->approvedAt;
    }

    public function setApprovedAt(?string $approvedAt): self {
        $this->approvedAt = $approvedAt;
        return $this;
    }

    public function isActive(): ?bool {
        return $this->active;
    }

    public function setActive(?bool $active): self {
        $this->active = $active;
        return $this;
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
                $rowsAffected = self::$repository->create($course);
                if ($rowsAffected) {
                    $this->id = intval(self::$repository->lastInsertId2());
                }
                break;
            }
            case EntityState::UPDATE: {
                $rowsAffected = self::$repository->update($course);
                break;
            }
        }
        return ($rowsAffected > 0) ? true : false;
    }
    
    // Obtener los mas vendidos
    // Obtener los mas recientes
    // Obtener los mejor calificados

    // No todas las propiedades de los modelos son de la entidad per se
    public static function findById(?int $id): ?CourseModel {
        $courseObject = self::$repository->findById($id);
        if (!$courseObject) {
            return null;
        }
        return new CourseModel($courseObject);
    }

    public static function findObjById(?int $id): ?array {
        $courseObject = self::$repository->findById($id);
        $courseObject["categories"] = explode(",", $courseObject["categories"]);
        return $courseObject;
    }

    public static function findByNotApproved(): ?array {
        return self::$repository->findByNotApproved();
    }

    public static function findAllOrderByCreatedAt(): ?array {
        return self::$repository->findAllOrderByCreatedAt();
    }

    public static function findAllOrderByRates(): ?array {
        return self::$repository->findAllOrderByRates();
    }

    public static function findAllOrderByEnrollments(): ?array {
        return self::$repository->findAllOrderByEnrollments();
    }

    public static function findSearch(?string $title, ?int $instructorId, ?int $categoryId,
    ?string $from = null, ?string $to = null, int $limit = 100, int $offset = 0): array {
        return self::$repository->courseSearch($title, $instructorId, $categoryId, $from, $to, $limit, $offset);
    }

    public static function findSearchTotal(?string $title, ?int $instructorId, ?int $categoryId,
    ?string $from = null, ?string $to = null, int $limit = 100, int $offset = 0): int {
        $obj = self::$repository->courseSearchTotal($title, $instructorId, $categoryId, $from, $to, $limit, $offset);
        return $obj["total"];
    }

    public static function salesReport(int $instructorId, ?int $categoryId = null,
    ?string $from = null, ?string $to = null, ?int $active = null,
    int $limit = 100, int $offset = 0): array {
        return self::$repository->courseSalesReport($instructorId, $categoryId, $from, $to, $active, $limit, $offset);
    }    
    
    public static function salesReportTotal(int $instructorId, ?int $categoryId = null,
    ?string $from = null, ?string $to = null, ?int $active = null): int {
        $obj = self::$repository->courseSalesReportTotal($instructorId, $categoryId, $from, $to, $active);
        return $obj["total"];
    }

    public static function kardexReport(int $studentId, ?int $categoryId = null,
    ?string $from = null, ?string $to = null, ?int $complete = null, ?int $active = null,
    int $limit = 100, int $offset = 0): array {
        return self::$repository->kardexReport($studentId, $from, $to, $categoryId, $complete, $active, $limit, $offset);
    }

    public static function kardexReportTotal(int $studentId, ?int $categoryId = null,
    ?string $from = null, ?string $to = null, ?int $complete = null, ?int $active = null): int {
        $obj = self::$repository->kardexReportTotal($studentId, $from, $to, $categoryId, $complete, $active);
        return $obj["total"];
    }

    public static function enrollmentsReport(int $courseId, ?string $from = null,
    ?string $to = null, int $limit = 100, int $offset = 0): array {
        return self::$repository->courseEnrollmentsReport($courseId, $from, $to, $limit, $offset);
    }

    public static function enrollmentsReportTotal(int $courseId, ?string $from = null,
    ?string $to = null): int {
        $obj = self::$repository->courseEnrollmentsReportTotal($courseId, $from, $to);
        return $obj["total"];
    }

    

    public static function init() {
        if (is_null(self::$repository)) {
            self::$repository = new CourseRepository();
        }
    }

    public function toArray(): ?array {
        return json_decode(json_encode($this), true);
    }

    public function jsonSerialize(): mixed {
        $properties = get_object_vars($this);
        $output = [];
        
        foreach ($properties as $name => $value) {
            if (in_array($name, $this->_ignores)) {
                 continue;
            }

            if ($name == '_ignores') {
                continue;
            }

            if (!($value instanceof Repository) && !($value instanceof EntityState)) {
                $output[$name] = $value;
            }
        }
        
        return $output;
    }

    public function setIgnores(array $ignores) {
        $this->_ignores = $ignores;
    }

    public function toObject() : array {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array {
        return array_keys(get_class_vars(self::class));
    }
}

CourseModel::init();