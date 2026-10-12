<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Facade;

use Exewen\Facades\AppFacade;
use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Lensen\BaseErp\Contract\ShippingInterface;

/**
 * @method static int    createPackageManual(array $params, array $header = [])
 * @method static array getCouriersList(array $params, array $header = [])
 */
class ShippingFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return ShippingInterface::class;
    }

    public static function getProviders(): array
    {
        AppFacade::getContainer()->singleton(ShippingInterface::class);

        return [
            LoggerProvider::class,
            HttpProvider::class,
        ];
    }
}
