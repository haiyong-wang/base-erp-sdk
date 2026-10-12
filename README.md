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

## 使用示例

```php
use Lensen\BaseErp\Facade\AuthFacade;
use Lensen\BaseErp\Facade\OrderFacade;

// 1. 设置 API Token
AuthFacade::setAuth('your-api-token');

// 2. 获取订单列表
$params = [
    'date_from' => strtotime('-1 day'), // Unix 时间戳
    'date_to'   => time(),
    // 'status_id' => 123,
    // 'get_unconfirmed_orders' => true,
];
$orders = OrderFacade::getOrders($params);
```
