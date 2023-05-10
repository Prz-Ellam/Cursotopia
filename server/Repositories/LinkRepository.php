<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Link;

class LinkRepository extends DB {
    private const CREATE = <<<'SQL'
        CALL `link_create`(:name, :address, @link_id)
    SQL;

    private const UPDATE = <<<'SQL'
        CALL `link_update`(
            :id, 
            :name, 
            :address, 
            :created_at, 
            :modified_at, 
            :active
        )
    SQL;

    private const FIND_BY_ID = <<<'SQL'
        CALL `link_find_by_id`(:id)
    SQL;

    public function create(Link $link): int {
        $parameters = [
            "name" => $link->getName(),
            "address" => $link->getAddress()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function update(Link $link): int {
        $parameters = [
            "id" => $link->getId(),
            "name" => $link->getName(),
            "address" => $link->getAddress(),
            "created_at" => $link->getCreatedAt(),
            "modified_at" => $link->getModifiedAt(),
            "active" => $link->getActive()
        ];
        return $this::executeNonQuery($this::UPDATE, $parameters);
    }

    public function findById(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_BY_ID, $parameters);
    }

    public function lastInsertId2(): string {
        return $this::executeOneReader("SELECT @link_id AS linkId", [])["linkId"];
    }
}
