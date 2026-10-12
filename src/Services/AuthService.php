<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;
use Lensen\BaseErp\Constants\BaseErpEnum;
use Lensen\BaseErp\Contract\AuthInterface;

class AuthService implements AuthInterface
{
    private $httpClient;
    private $driver;
    private $config;

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('base_erp.' . BaseErpEnum::CHANNEL_API);
        $this->config     = $config;
    }


    public function setAuth(string $accessToken, string $channel = BaseErpEnum::CHANNEL_API)
    {
        $this->config->set('http.channels.' . $channel . '.extra.access_token', $accessToken);
    }

}
