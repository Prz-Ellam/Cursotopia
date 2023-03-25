<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;

class RoleRepository extends DB {
    private const FIND_ALL_BY_IS_PUBLIC = <<<'SQL'
        SELECT
            `user_role_id` AS `id`,
            `user_role_name` AS `name`,
            `user_role_is_public` AS `is_public`,
            `user_role_created_at` AS `created_at`,
            `user_role_modified_at` AS `modified_at`,
            `user_role_active` AS `active`
        FROM
            `user_roles`
        WHERE
            `user_role_is_public` = :is_public
    SQL;

    private const FIND_ONE_BY_ID_AND_PUBLIC = <<<'SQL'
        SELECT
            `user_role_id` AS `id`,
            `user_role_name` AS `name`,
            `user_role_is_public` AS `is_public`,
            `user_role_created_at` AS `created_at`,
            `user_role_modified_at` AS `modified_at`,
            `user_role_active` AS `active`
        FROM
            `user_roles`
        WHERE
            `user_role_id` = :id
            AND `user_role_is_public` = :is_public
        LIMIT
            1 
    SQL;

    /**
     * Regresa todos los roles de usuario publicos
     *
     * @param boolean $isPublic
     * @return array
     */
    public function findAllByIsPublic(bool $isPublic): array {
        return $this::executeReader($this::FIND_ALL_BY_IS_PUBLIC, [ "is_public" => $isPublic ]);
    }

    /**
     * Busca si existe un rol con ese id y is_public
     *
     * @param integer $id
     * @param boolean $isPublic
     * @return array
     */
    public function findOneByIdAndIsPublic(int $id, bool $isPublic): ?array {
        return $this::executeOneReader($this::FIND_ONE_BY_ID_AND_PUBLIC, [ 
            "id" => $id,
            "is_public" => $isPublic 
        ]) ?? null;
    }
}
