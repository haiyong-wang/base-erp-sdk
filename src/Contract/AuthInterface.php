<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Contract;

use Lensen\BaseErp\Constants\BaseErpEnum;

interface AuthInterface
{
    public function setAuth(string $accessToken, string $channel = BaseErpEnum::CHANNEL_API);
}
