<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;
use PDO;

class RoleRepository extends DB {
    private const FIND_ALL_BY_IS_PUBLIC = <<<'SQL'
        CALL `role_find_all_by_is_public`(:is_public)
    SQL;

    private const FIND_ONE_BY_ID_AND_PUBLIC = <<<'SQL'
        CALL `role_find_by_id_and_is_public`(:id, :is_public)
    SQL;

    /**
     * Regresa todos los roles de usuario publicos
     *
     * @param boolean $isPublic
     * @return array
     */
    public function findAllByIsPublic(?bool $isPublic): ?array {
        $parameters = [
            "is_public" => $isPublic
        ];
        $types = [
            "is_public" => PDO::PARAM_BOOL
        ];
        return $this::executeReader($this::FIND_ALL_BY_IS_PUBLIC, $parameters, $types);
    }

    /**
     * Busca si existe un rol con ese id y is_public
     *
     * @param integer $id
     * @param boolean $isPublic
     * @return array
     */
    public function findOneByIdAndIsPublic(?int $id, ?bool $isPublic): ?array {
        $parameters = [
            "id" => $id,
            "is_public" => $isPublic
        ];
        $types = [
            "id" => PDO::PARAM_INT,
            "is_public" => PDO::PARAM_BOOL
        ];
        return $this::executeOneReader($this::FIND_ONE_BY_ID_AND_PUBLIC, 
            $parameters,
            $types
        );
    }
}
