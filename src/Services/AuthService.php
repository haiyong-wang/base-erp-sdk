<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;
use Lensen\BaseErp\Constants\BaseErpEnum;
use Lensen\BaseErp\Contract\AuthInterface;

class AuthService implements AuthInterface
{
    /**
     * 默认从环境变量读取 Baselinker Token 的 key
     * 可在调用 setAuth 时通过第二参数自定义 key 名
     */
    private const ENV_TOKEN_KEY = 'BASE_ERP_TOKEN';

    private $httpClient;
    private $driver;
    private $config;

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('base_erp.' . BaseErpEnum::CHANNEL_API);
        $this->config     = $config;
    }

    /**
     * 设置 API Token
     *
     * 使用优先级：
     *  1. 显式传入的 $accessToken
     *  2. 第二个参数指定的 env key
     *  3. 默认 env key：BASE_ERP_TOKEN
     *
     * 示例（.env）:
     *   BASE_ERP_TOKEN=123-ABC-...
     *
     * @param string $accessToken 显式 token（可选；为空时从 env 读取）
     * @param string $channel     http 渠道名
     * @param string $envKey      自定义 env key（可选）
     * @return string  最终生效的 token
     * @throws \RuntimeException 当 token 仍为空时抛出
     */
    public function setAuth(string $accessToken = '', string $channel = BaseErpEnum::CHANNEL_API, string $envKey = self::ENV_TOKEN_KEY)
    {
        $token = $accessToken;
        if ($token === '') {
            $token = $this->getEnv($envKey);
        }
        if ($token === '') {
            throw new \RuntimeException(sprintf(
                'BaseErp: API token 为空，请通过 setAuth("%s") 显式传入，或在 .env 中设置 %s',
                'your-token',
                $envKey
            ));
        }

        $this->config->set('http.channels.' . $channel . '.extra.access_token', $token);
        return $token;
    }

    /**
     * 读取环境变量
     * - 优先使用 getenv()
     * - 兼容 $_SERVER
     * - 兼容 .env 中用 export 前缀
     */
    private function getEnv(string $key): string
    {
        $value = getenv($key);
        if ($value === false || $value === '') {
            $value = $_SERVER[$key] ?? $_ENV[$key] ?? '';
        }
        return is_string($value) ? trim($value) : '';
    }

}
