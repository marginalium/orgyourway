<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    var_dump($_SERVER['MYSQL_UNIX_SOCKET']);
    var_dump($_ENV['MYSQL_UNIX_SOCKET']);
    if (empty($context['APP_ENV'])) {
        $context['APP_ENV'] = 'dev';
    }
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
