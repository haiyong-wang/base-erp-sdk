<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Constants\HttpEnum;
use Exewen\Http\Contract\HttpClientInterface;
use Lensen\BaseErp\Constants\BaseErpEnum;
use Lensen\BaseErp\Contract\ShippingInterface;

class ShippingService extends BaseService implements ShippingInterface
{
    private $httpClient;
    private $driver;

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('base_erp.' . BaseErpEnum::CHANNEL_API);
    }

    /**
     * 手动创建运单包裹
     * @param array $params
     *   - order_id        int    订单 ID（必填）
     *   - courier_code    string 快递公司编码（必填）
     *   - package_number  string 包裹追踪号（必填）
     *   - pickup_date     int    取件日期 Unix 时间戳（可选）
     * @param array $header
     * @return int package_id
     */
    public function createPackageManual(array $params, array $header = []): int
    {
        $requestParams = [
            'method'     => 'createPackageManual',
            'parameters' => json_encode($params, JSON_UNESCAPED_UNICODE),
        ];
        $response = $this->httpClient->post($this->driver, '/connector.php', $requestParams, $header, [], HttpEnum::TYPE_FORM);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return (int)($result['package_id'] ?? 0);
    }

    /**
     * 获取可用快递公司列表
     * @param array $params
     *   - filter_active bool 是否只返回启用状态（可选）
     * @param array $header
     * @return array couriers
     */
    public function getCouriersList(array $params, array $header = []): array
    {
        $requestParams = [
            'method'     => 'getCouriersList',
            'parameters' => json_encode($params, JSON_UNESCAPED_UNICODE),
        ];
        $response = $this->httpClient->post($this->driver, '/connector.php', $requestParams, $header, [], HttpEnum::TYPE_FORM);
        $result   = json_decode($response->getBody()->getContents(), true);
        $this->checkResponse($result);
        return $result['couriers'] ?? [];
    }

}
