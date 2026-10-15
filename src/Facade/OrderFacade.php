<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Facade;

use Exewen\Facades\AppFacade;
use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Lensen\BaseErp\Contract\OrderInterface;

/**
 * @method static array getOrders(array $params, array $header = [])
 * @method static array getJournalList(array $params, array $header = [])
 * @method static array getOrderReturns(array $params, array $header = [])
 * @method static array getOrderSources(array $params = [], array $header = [])
 * @method static array getOrderStatusList(array $params = [], array $header = [])
 */
class OrderFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return OrderInterface::class;
    }

    public static function getProviders(): array
    {
        AppFacade::getContainer()->singleton(OrderInterface::class);

        return [
            LoggerProvider::class,
            HttpProvider::class,
        ];
    }
}
