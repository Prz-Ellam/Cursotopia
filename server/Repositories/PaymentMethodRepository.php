<?php

namespace Cursotopia\Repositories;

use Bloom\Database\DB;

class PaymentMethodRepository extends DB {
    const FIND_BY_ID = <<<'SQL'
        CALL `payment_method_find_by_id`(:id)
    SQL;

    public function findById(?int $paymentMethodId): ?array {
        $parameters = [
            "id" => $paymentMethodId
        ];
        return $this::executeOneReader($this::FIND_BY_ID, $parameters);
    }
}
