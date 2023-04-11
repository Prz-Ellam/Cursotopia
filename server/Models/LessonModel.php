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
}
