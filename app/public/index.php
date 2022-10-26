<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    if (empty($context['APP_ENV'])) {
        $context['APP_ENV'] = 'prod';
    }
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
