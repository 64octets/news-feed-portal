<?php

error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '1512M');
date_default_timezone_set('Europe/Kiev');

require_once __DIR__ . '/../vendor/autoload.php';
$dbConfig = require_once __DIR__ . '/etc/propel.php';

Engine::init($dbConfig['propel']['database']['connections']);

require_once 'TestHelper.php';
require_once 'LocalWebTestCase.php';

\Validator\LIVR::registerDefaultRules([
    'equals' => function ($expected) {
        return function ($got) use ($expected) {
            if ($got != $expected) {
                return 'NOT_EQUILAS';
            }
        };
    },
    'strict_equals' => function ($expected) {
        return function ($got) use ($expected) {
            if ($got !== $expected) {
                return 'NOT_EQUILAS';
            }
        };
    },
    'empty_array' => function () {
        return function ($got) {
            if (!is_array($got) || count($got)) {
                return 'NOT_EMPTY_ARRAY';
            }
        };
    },
    'array' => function () {
        return function ($got) {
            if (!is_array($got)) {
                return 'NOT_ARRAY';
            }
        };
    },
]);
