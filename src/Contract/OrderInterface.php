<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Contract;

interface OrderInterface
{
    public function getOrders(array $params, array $header = []);

    public function getJournalList(array $params, array $header = []);

    public function getOrderReturns(array $params, array $header = []);

    public function getOrderSources(array $params = [], array $header = []);
}
