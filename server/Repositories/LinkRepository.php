<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use Cursotopia\Entities\Link;

class LinkRepository extends DB {
    private const FIND_ONE = <<<'SQL'
        SELECT
            link_id AS `id`,
            link_name AS `name`,
            link_address AS `address`,
            link_created_at AS `createdAt`,
            link_modified_at AS `modifiedAt`,
            link_active AS `active`
        FROM
            links
        WHERE
            link_id = :id
        LIMIT
            1;
    SQL;

    private const CREATE = <<<'SQL'
        INSERT INTO links(
            link_name,
            link_address
        )
        SELECT
            :name,
            :address
        FROM
            dual
        WHERE
            :name IS NOT NULL
            AND :address IS NOT NULL
    SQL;
    private const UPDATE = "";

    public function create(Link $link) {
        $parameters = [
            "name" => $link->getName(),
            "address" => $link->getAddress()
        ];
        return $this::executeNonQuery($this::CREATE, $parameters);
    }

    public function findOne(?int $id): ?array {
        $parameters = [
            "id" => $id
        ];
        return $this::executeOneReader($this::FIND_ONE, $parameters);
    }
}
