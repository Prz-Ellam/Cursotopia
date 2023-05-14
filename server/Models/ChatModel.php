<?php

namespace Cursotopia\Models;

use Cursotopia\Repositories\ChatRepository;
use Cursotopia\Repositories\Repository;
use Cursotopia\ValueObjects\EntityState;

class ChatModel {
    private static ?ChatRepository $repository = null;
    private EntityState $entityState;
    private array $_ignores = [];

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
    }

    public static function findOneByUsers($userOne, $userTwo) {
        return self::$repository->findChat($userOne, $userTwo);
    }

    public static function findAllByUser($userId) {
        return self::$repository->findAllByUserId($userId);
    }

    public static function init() {
        if (is_null(self::$repository)) {
            self::$repository = new ChatRepository();
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

ChatModel::init();