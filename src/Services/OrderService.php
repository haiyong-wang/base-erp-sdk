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
        $response = $this->request('getOrders', $params, $header);
        return $response['orders'] ?? [];
    }

    /**
     * 获取订单事件日志
     * @param array $params
     *   - last_log_id    int   增量获取，传入上次最大 log_id
     *   - logs_types     array 日志类型筛选，如 [1,2,3]
     *   - order_id       array 订单 ID 列表（可选）
     * @param array $header
     * @return array logs
     */
    public function getJournalList(array $params, array $header = []): array
    {
        $response = $this->request('getJournalList', $params, $header);
        return $response['logs'] ?? [];
    }

    /**
     * 获取订单退货列表
     * @param array $params
     *   - id        int   订单 ID（可选）
     *   - date_from int   Unix 时间戳
     *   - date_to   int   Unix 时间戳
     *   - status_id int   退货状态（可选）
     * @param array $header
     * @return array returns
     */
    public function getOrderReturns(array $params, array $header = []): array
    {
        $response = $this->request('getOrderReturns', $params, $header);
        return $response['returns'] ?? [];
    }

    /**
     * 获取订单来源（市场/平台）列表
     * @param array $params 无业务参数
     * @param array $header
     * @return array sources
     */
    public function getOrderSources(array $params = [], array $header = []): array
    {
        $response = $this->request('getOrderSources', $params, $header);
        return $response['sources'] ?? [];
    }

    /**
     * 通用请求方法：POST 表单到 /connector.php
     */
    private function request(string $method, array $params, array $header = []): array
    {
        $requestParams = [
            'method'     => $method,
            'parameters' => json_encode($params, JSON_UNESCAPED_UNICODE),
        ];
        $response = $this->httpClient->post($this->driver, '/connector.php', $requestParams, $header, [], HttpEnum::TYPE_FORM);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return $result;
    }

}
