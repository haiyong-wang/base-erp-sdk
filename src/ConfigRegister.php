<?php

declare(strict_types=1);

namespace Lensen\BaseErp;

use Exewen\Http\Middleware\LogMiddleware;
use Lensen\BaseErp\Constants\BaseErpEnum;
use Lensen\BaseErp\Middleware\AuthMiddleware;

class ConfigRegister
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                Contract\AuthInterface::class  => Services\AuthService::class,
                Contract\OrderInterface::class => Services\OrderService::class,
            ],

            'base_erp' => [
                BaseErpEnum::CHANNEL_API => BaseErpEnum::CHANNEL_API,
            ],

            'http' => [
                'channels' => [
                    BaseErpEnum::CHANNEL_API => [
                        'verify'          => false,
                        'ssl'             => true,
                        'host'            => 'api.baselinker.com',
                        'port'            => null,
                        'prefix'          => null,
                        'connect_timeout' => 3,
                        'timeout'         => 20,
                        'handler'         => [
                            AuthMiddleware::class,
//                             LogMiddleware::class,
                        ],
                        'extra'           => [],
                        'proxy'           => [
                            'switch' => false,
                            'http'   => '127.0.0.1:8888',
                            'https'  => '127.0.0.1:8888'
                        ]
                    ],
                ]
            ]

        ];
    }
}
