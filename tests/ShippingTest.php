<?php
declare(strict_types=1);
namespace LensenTest\BaseErp;

use Lensen\BaseErp\Facade\AuthFacade;
use Lensen\BaseErp\Facade\ShippingFacade;

class ShippingTest extends Base
{
    public function testCreatePackageManual()
    {
        AuthFacade::setAuth();

        $params = [
            'order_id'       => 12345,
            'courier_code'   => 'DPD',
            'package_number' => 'TRACK-123456789',
            'pickup_date'    => strtotime('today'),
        ];
        $packageId = ShippingFacade::createPackageManual($params);

        $this->assertGreaterThan(0, $packageId);
    }

    public function testGetCouriersList()
    {
        AuthFacade::setAuth();

        $params = [
            'filter_active' => true,
        ];
        $couriers = ShippingFacade::getCouriersList($params);

        $this->assertNotEmpty($couriers);
    }
}
