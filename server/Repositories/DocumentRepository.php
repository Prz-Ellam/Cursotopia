<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Document;

class DocumentRepository extends DB {
    private const CREATE = <<<'SQL'
        INSERT INTO documents(
            document_name,
            document_content_type,
            document_address
        )
        VALUES(
            :name,
            :content_type,
            :address
        )
    SQL;

    private const FIND_BY_ID = <<<'SQL'
        SELECT
            `document_id` AS `id`,
            `document_name` AS `name`,
            `document_content_type` AS `contentType`,
            `document_address` AS `address`,
            `document_created_at` AS `createdAt`,
            `document_modified_at` AS `modifiedAt`,
            `document_active` AS `active`
        FROM
            `documents`
        WHERE
            `document_id` = :document_id
        LIMIT
            1;
    SQL;

    public function create(Document $document): int {
        $parameters = [
            "name" => $document->getName(),
            "content_type" => $document->getContentType(),
            "address" => $document->getAddress()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function findById(?int $id): ?array {
        $parameters = [
            "document_id" => $id
        ];
        return $this::executeOneReader($this::FIND_BY_ID, $parameters);
    }
}
