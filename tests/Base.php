<?php
declare(strict_types=1);

namespace LensenTest\BaseErp;

use Exewen\Di\Context\ApplicationContext;
use Exewen\Config\Contract\ConfigInterface;
use Lensen\BaseErp\ConfigRegister;
use PHPUnit\Framework\TestCase;

class Base extends TestCase
{
    public function __construct()
    {
        parent::__construct();
        !defined('BASE_PATH_PKG') && define('BASE_PATH_PKG', dirname(__DIR__, 1));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadEnv(dirname(__DIR__) . '/.env');
    }

    /**
     * 极简 .env 加载器（无第三方依赖）
     * - 跳过空行与 # 注释
     * - 支持 KEY=VALUE 与 "KEY=VALUE" / 'KEY=VALUE'
     * - 已存在的环境变量不会被覆盖
     */
    private function loadEnv(string $path): void
    {
        if (!is_file($path) || !is_readable($path)) {
            return;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }
            if (strpos($line, '=') === false) {
                continue;
            }
            [$key, $value] = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value);
            $value = trim($value, "\"'");
            if ($key === '' || getenv($key) !== false) {
                continue;
            }
            putenv("{$key}={$value}");
            $_ENV[$key]    = $value;
            $_SERVER[$key] = $value;
        }
    }

}
