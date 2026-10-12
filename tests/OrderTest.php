<?php
declare(strict_types=1);
namespace LensenTest\BaseErp;

use Lensen\BaseErp\Facade\AuthFacade;
use Lensen\BaseErp\Facade\OrderFacade;

class OrderTest extends Base
{
    public function testGetOrders()
    {
        // 从 .env 读取 BASE_ERP_TOKEN
        AuthFacade::setAuth();

        $params = [
            'date_from' => strtotime('-1 day'),
            'date_to'   => time(),
        ];
        $response = OrderFacade::getOrders($params);

        $this->assertNotEmpty($response);
    }

    public function testGetJournalList()
    {
        AuthFacade::setAuth();

        $params = [
            'last_log_id' => 0,
            'logs_types'  => [],
        ];
        $response = OrderFacade::getJournalList($params);

        $this->assertNotEmpty($response);
    }

    public function testGetOrderReturns()
    {
        AuthFacade::setAuth();

        $params = [
            'date_from' => strtotime('-7 day'),
            'date_to'   => time(),
        ];
        $response = OrderFacade::getOrderReturns($params);

        $this->assertNotEmpty($response);
    }

    public function testGetOrderSources()
    {
        AuthFacade::setAuth();

        $sources = OrderFacade::getOrderSources();

        $this->assertNotEmpty($sources);
    }
}
