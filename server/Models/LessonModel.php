<?php

namespace Cursotopia\Models;

use Cursotopia\Repositories\LessonRepository;

class LessonModel {
    public function __construct(?array $object) {
        
    }

    public static function findById(int $id) {
        $lessonRepository = new LessonRepository();
        $lessonObject = $lessonRepository->findById($id);
        if (!$lessonObject) {
            return null;
        }
        return new LessonModel($lessonObject);
    }

    public static function findByLevel(int $levelId) {
        $lessonRepository = new LessonRepository();
        return $lessonRepository->findByLevel($levelId);
    }

    public function toObject() : array {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array {
        return array_keys(get_class_vars(self::class));
    }
}
