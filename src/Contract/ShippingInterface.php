<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Contract;

interface ShippingInterface
{
    public function createPackageManual(array $params, array $header = []);

    public function getCouriersList(array $params, array $header = []);
}
