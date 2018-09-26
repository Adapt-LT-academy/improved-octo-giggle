<?php

use App\Kernel;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../vendor/autoload.php';

// The check is to ensure we don't use .env in production
if (!isset($_SERVER['APP_ENV'])) {
    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
    }
    (new Dotenv())->load(__DIR__.'/../.env');
}

$env = $_SERVER['APP_ENV'] ?? 'dev';
$debug = (bool) ($_SERVER['APP_DEBUG'] ?? ('prod' !== $env));

includeCodeceptionDebugger($env);

if ($debug) {
    umask(0000);

    Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts(explode(',', $trustedHosts));
}

$kernel = new Kernel($env, $debug);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);


function includeCodeceptionDebugger($env)
{
    $c3Path = __DIR__ . '/../c3.php';
    if (!\in_array($env, ['dev', 'test']) || !file_exists($c3Path)) {
        return;
    }

    if (!function_exists('codecept_root_dir')) {
        function codecept_root_dir($appendPath = '')
        {
            return \Codeception\Configuration::projectDir() . $appendPath;
        }
    }

    if (!function_exists('codecept_absolute_path')) {
        /**
         * If $path is absolute, it will be returned without changes.
         * If $path is relative, it will be passed to `codecept_root_dir()` function
         * to make it absolute.
         *
         * @param string $path
         * @return string the absolute path
         */
        function codecept_absolute_path($path)
        {
            return codecept_is_path_absolute($path) ? $path : codecept_root_dir($path);
        }
    }

    if (!function_exists('codecept_is_path_absolute')) {
        /**
         * Check whether the given $path is absolute.
         *
         * @param string $path
         * @return bool
         * @since 2.4.4
         */
        function codecept_is_path_absolute($path)
        {
            if (DIRECTORY_SEPARATOR === '/') {
                return mb_substr($path, 0, 1) === DIRECTORY_SEPARATOR;
            }

            return preg_match('#^[A-Z]:(?![^/\\\])#i', $path) === 1;
        }
    }

    require $c3Path;
}
