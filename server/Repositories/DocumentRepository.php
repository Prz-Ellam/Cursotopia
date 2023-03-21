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
        SELECT
            :name,
            :content_type,
            :address
        FROM
            dual
        WHERE
            :name IS NOT NULL
            AND :content_type IS NOT NULL
            AND :address IS NOT NULL
    SQL;

    private const FIND_ONE = <<<'SQL'
        SELECT
            document_id AS `id`,
            document_name AS `name`,
            document_content_type AS `content_type`,
            document_address AS `address`,
            document_created_at AS `createdAt`,
            document_modified_at AS `modifiedAt`,
            document_active AS `active`
        FROM
            documents
        WHERE
            document_id = :id
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

    public function findOne(int $id): array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_ONE, $parameters);
    }
}
