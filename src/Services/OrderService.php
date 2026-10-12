<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Constants\HttpEnum;
use Exewen\Http\Contract\HttpClientInterface;
use Lensen\BaseErp\Constants\BaseErpEnum;
use Lensen\BaseErp\Contract\OrderInterface;

class OrderService extends BaseService implements OrderInterface
{
    private $httpClient;
    private $driver;

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('base_erp.' . BaseErpEnum::CHANNEL_API);
    }

    /**
     * 获取订单列表
     * @param array $params 见 https://api.baselinker.com/index.php?method=getOrders
     *                      如 date_from/date_to(Unix时间戳)、status_id、get_unconfirmed_orders 等
     * @param array $header
     * @return array
     */
    public function getOrders(array $params, array $header = []): array
    {
        $requestParams = [
            'method'     => 'getOrders',
            'parameters' => json_encode($params, JSON_UNESCAPED_UNICODE),
        ];
        $response = $this->httpClient->post($this->driver, '/connector.php', $requestParams, $header, [], HttpEnum::TYPE_FORM);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return $result['orders'] ?? [];
    }

}
