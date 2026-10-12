<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Facade;

use Exewen\Facades\AppFacade;
use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Lensen\BaseErp\Constants\BaseErpEnum;
use Lensen\BaseErp\Contract\AuthInterface;

/**
 * @method static array setAuth(string $accessToken, string $channel = BaseErpEnum::CHANNEL_API)
 */
class AuthFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return AuthInterface::class;
    }

    public static function getProviders(): array
    {
        AppFacade::getContainer()->singleton(AuthInterface::class);

        return [
            LoggerProvider::class,
            HttpProvider::class,
        ];
    }
}
