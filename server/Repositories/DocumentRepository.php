<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Document;

class DocumentRepository extends DB implements Repository {
    private const CREATE = <<<'SQL'
        CALL `document_create`(
            :name, 
            :content_type, 
            :address, 
            @document_id
        )
    SQL;

    private const UPDATE = <<<'SQL'
        CALL `document_update`(
            :id, 
            :name, 
            :content_type, 
            :address, 
            :created_at, 
            :modified_at, 
            :active
        )
    SQL;

    private const FIND_BY_ID = <<<'SQL'
        CALL `document_find_by_id`(:id)
    SQL;

    private const CHECK_RESOURCE_AVAILABILITY_BY_USER = <<<'SQL'
        SELECT 
            l.`level_is_free` AS `free`, 
            e.`enrollment_is_paid` AS `paid`,
            c.`course_price` AS `price`
        FROM `lessons` AS le
        INNER JOIN `levels` AS l
        ON le.`level_id` = l.`level_id`
        INNER JOIN `enrollments` AS e
        ON l.`course_id` = e.`course_id` AND e.`student_id` = :user_id
        INNER JOIN `courses` AS c
        ON e.`course_id` = c.`course_id`
        WHERE `document_id` = :document_id
    SQL;

    public function create(Document $document): int {
        $parameters = [
            "name" => $document->getName(),
            "content_type" => $document->getContentType(),
            "address" => $document->getAddress()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function update(Document $document): int {
        $parameters = [
            "id" => $document->getId(),
            "name" => $document->getName(),
            "content_type" => $document->getContentType(),
            "address" => $document->getAddress(),
            "created_at" => $document->getCreatedAt(),
            "modified_at" => $document->getModifiedAt(),
            "active" => $document->isActive()
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }
    
    public function findById(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_BY_ID, $parameters);
    }

    public function checkAvailabityByUser(?int $userId, ?int $documentId): ?array {
        $parameters = [
            "user_id" => $userId,
            "document_id" => $documentId
        ];
        return $this::executeOneReader($this::CHECK_RESOURCE_AVAILABILITY_BY_USER, $parameters);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @document_id AS documentId", [])["documentId"];
    }
}
