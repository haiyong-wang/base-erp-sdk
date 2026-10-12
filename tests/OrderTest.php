<?php
declare(strict_types=1);
namespace LensenTest\BaseErp;

use Lensen\BaseErp\Facade\OrderFacade;
use Lensen\BaseErp\Facade\AuthFacade;

class OrderTest extends Base
{
    public function testGetOrders()
    {
        // 设置 API Token（在 Baselinker 面板 "Account & other -> My account -> API section" 生成）
//         AuthFacade::setAuth('xxx');

        // 测试获取订单列表功能
        $params = [
            'date_from' => strtotime('-1 day'), // Unix 时间戳
            'date_to'   => time(),
        ];
        $response = OrderFacade::getOrders($params);

        $this->assertNotEmpty($response);
    }
}
