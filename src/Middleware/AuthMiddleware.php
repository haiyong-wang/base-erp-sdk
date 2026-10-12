<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Middleware;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Facades\AppFacade;
use Psr\Http\Message\RequestInterface;

class AuthMiddleware
{
    private $appConfig;
    private $config;
    private $channel;

    public function __construct(string $channel, array $config)
    {
        $this->appConfig = AppFacade::getContainer()->get(ConfigInterface::class);
        $this->channel   = $channel;
        $this->config    = $config;
    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {

            $this->config = $this->appConfig->get("http.channels.{$this->channel}"); // 刷新单例到最新配置
            $accessToken  = $this->config['extra']['access_token'] ?? '';

            // BaseLinker 推荐通过请求头 X-BL-Token 传递 API Token
            $request = $request->withHeader('X-BL-Token', $accessToken);

            return $handler($request, $options);
        };
    }

}
