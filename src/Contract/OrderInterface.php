<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Contract;

interface OrderInterface
{
    public function getOrders(array $params, array $header = []);
}
