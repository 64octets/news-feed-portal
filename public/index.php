<?php

date_default_timezone_set('Europe/Kiev');

require_once __DIR__ . '/../vendor/autoload.php';
$appConf = require_once __DIR__ . '/../etc/app-conf.php';
$dbConfig = require_once __DIR__ . '/../etc/propel.php';

Engine::init($dbConfig['propel']['database']['connections']);
AppFactory::create($appConf)->add(new \Slim\Middleware\SessionCookie(['expires' => '1 day']));
AppFactory::$slimInstance->run();
