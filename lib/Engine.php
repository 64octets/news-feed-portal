<?php

class Engine
{
    public static function init($config)
    {
        foreach ($config as $name => $connection) {
            static::initConnection($name, $connection);
        }
    }

    private static function initConnection($name, $config)
    {
        $serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
        $serviceContainer->checkVersion('2.0.0-dev');
        $serviceContainer->setAdapterClass($name, $config['adapter']);
        $manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
        $manager->setConfiguration([
            'classname'  => $config['classname'],
            'dsn'        => $config['dsn'],
            'user'       => $config['user'],
            'password'   => $config['password'],
            'attributes' => $config['attributes'],
        ]);
        $manager->setName($name);
        $serviceContainer->setConnectionManager($name, $manager);
        $serviceContainer->setDefaultDatasource($name);
    }
}
