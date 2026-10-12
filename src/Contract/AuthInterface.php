<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Contract;

use Lensen\BaseErp\Constants\BaseErpEnum;

interface AuthInterface
{
    /**
     * 设置 API Token
     * @param string $accessToken 显式 token；为空则从 env 读取
     * @param string $channel     http 渠道名
     * @param string $envKey      自定义 env key，默认 BASE_ERP_TOKEN
     * @return string  最终生效的 token
     */
    public function setAuth(
        string $accessToken = '',
        string $channel = BaseErpEnum::CHANNEL_API,
        string $envKey = 'BASE_ERP_TOKEN'
    );
}
