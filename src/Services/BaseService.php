<?php
declare(strict_types=1);

namespace Lensen\BaseErp\Services;

use Lensen\BaseErp\Exception\BaseErpException;

class BaseService
{
    /**
     * 通用响应检查
     * BaseLinker 响应格式: {"status": "SUCCESS", ...} 或 {"status": "ERROR", "error_code": xxx, "error_message": "xxx"}
     * @param $result
     * @return void
     */
    protected function checkResponse($result)
    {
        if (!is_array($result)) {
            throw new BaseErpException('BaseErp:' . __FUNCTION__ . '响应解析异常');
        }
        if (!isset($result['status'])) {
            throw new BaseErpException('BaseErp:' . __FUNCTION__ . '响应格式异常');
        }
        if ($result['status'] !== 'SUCCESS') {
            $errorCode    = $result['error_code'] ?? '';
            $errorMessage = $result['error_message'] ?? '';
            throw new BaseErpException('BaseErp:' . __FUNCTION__ . '响应status异常(' . $errorCode . ') ' . $errorMessage);
        }
    }

}
