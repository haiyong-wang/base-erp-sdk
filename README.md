# base-erp-sdk (Baselinker)

Baselinker (Base ERP) PHP SDK 组件，基于 exewen 组件风格开发，参考 temu-php-sdk-new 架构。

## API 说明

- 请求地址: `https://api.baselinker.com/connector.php`
- 请求方式: `POST`
- 认证方式: 请求头 `X-BL-Token` 传递 API Token（推荐），Token 在 Baselinker 面板 "Account & other -> My account -> API section" 生成
- 请求参数（form 表单提交）:
  1. `token` - 已废弃，改用 X-BL-Token 请求头
  2. `method` - 请求的 API 方法名，如 `getOrders`
  3. `parameters` - 请求方法参数（JSON 格式）

## 初始化

```php
# 定义 composer 加载路径
!defined('BASE_PATH_PKG') && define('BASE_PATH_PKG', dirname(__DIR__, 1));
```

## 鉴权配置

SDK 通过 `X-BL-Token` 请求头携带 Token。`setAuth()` 支持三种来源（按优先级）：

1. **显式传入**：`AuthFacade::setAuth('123-ABC-...')`
2. **自定义 env key**：`AuthFacade::setAuth('', BaseErpEnum::CHANNEL_API, 'MY_TOKEN_KEY')`
3. **默认 env key `BASE_ERP_TOKEN`**：在 `.env` 配置后无需传参

### 推荐：在 `.env` 中配置

```
BASE_ERP_TOKEN=123-ABC-...
```

## 使用示例

```php
use Lensen\BaseErp\Facade\AuthFacade;
use Lensen\BaseErp\Facade\OrderFacade;
use Lensen\BaseErp\Facade\ShippingFacade;

// 1. 设置 API Token（推荐从 .env 读取，无需传参）
AuthFacade::setAuth();
// 或显式传入：
// AuthFacade::setAuth('your-api-token');

// 2. 订单相关
$orders   = OrderFacade::getOrders(['date_from' => strtotime('-1 day'), 'date_to' => time()]);
$logs     = OrderFacade::getJournalList(['last_log_id' => 0]);
$returns  = OrderFacade::getOrderReturns(['date_from' => strtotime('-7 day'), 'date_to' => time()]);
$sources  = OrderFacade::getOrderSources();

// 3. 物流相关
$couriers  = ShippingFacade::getCouriersList(['filter_active' => true]);
$packageId = ShippingFacade::createPackageManual([
    'order_id'       => 12345,
    'courier_code'   => 'DPD',
    'package_number' => 'TRACK-123456789',
    'pickup_date'    => strtotime('today'),
]);
```

## 已实现接口

### OrderFacade
| 方法 | 描述 |
| --- | --- |
| `getOrders(array $params)` | 获取订单列表 |
| `getJournalList(array $params)` | 获取订单事件日志（增量） |
| `getOrderReturns(array $params)` | 获取订单退货列表 |
| `getOrderSources(array $params = [])` | 获取订单来源（市场/平台）列表 |

### ShippingFacade
| 方法 | 描述 |
| --- | --- |
| `createPackageManual(array $params)` | 手动创建运单包裹 |
| `getCouriersList(array $params)` | 获取可用快递公司列表 |

### AuthFacade
| 方法 | 描述 |
| --- | --- |
| `setAuth(string $accessToken = '', string $channel = ..., string $envKey = 'BASE_ERP_TOKEN')` | 设置 API Token（默认从 env `BASE_ERP_TOKEN` 读取） |
