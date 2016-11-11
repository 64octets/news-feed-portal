<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Propel\Runtime\Propel;

class AppFactory
{
    public static $slimInstance;

    public static function create($config)
    {
        // Create monolog logger and store logger in container as singleton
        // (Singleton resources retrieve the same log resource definition each time)
        // Prepare app
        $app = new \Slim\Slim($config['slimOptions']);
        $app->config = $config;

        $app->container->singleton('log', function () use ($app) {
            $log = new \Monolog\Logger($app->config['loggerOptions']['name']);

            $log->pushHandler(
                new \Monolog\Handler\StreamHandler($app->config['loggerOptions']['filepath'], \Monolog\Logger::DEBUG)
            );

            return $log;
        });

        $logger = new Logger('propel');
        $logger->pushHandler(new StreamHandler(
            $app->config['loggerOptions']['propelpath'],
            Logger::DEBUG
        ));
        Propel::getServiceContainer()->setLogger('defaultLogger', $logger);

        // Prepare middleware

        // Catch Errors
        $app->notFound(function () use ($app) {
            $res['Error'] = true;
            $app->render('404.php', $res);
        });

        $app->error(function (\Exception $e) use ($app) {
            $res['Error'] = true;
            $app->log->error($e);
            $app->render('500.php', $res);
        });

        // Define routes
        $app->get('/:path*', function () use ($app) {
            $app->render('index.php');
        });

        // Define API routes
        $app->group('/api/v1', function () use ($app) {
            $app->group('/feeds', function () use ($app) {
                $feed = new \Controller\Feed($app);
                $app->get('/', [$feed, 'index' ])->name('feed_index');
                $app->get('/publication_dates', [$feed, 'pubDates' ])->name('feed_pub_dates');
                $app->get('/:Id', [$feed, 'show'  ])->name('feed_show');
                $app->post('/', [$feed, 'create'])->name('feed_create');
                $app->post('/:Id', [$feed, 'update'])->name('feed_update');
                $app->delete('/:Id', [$feed, 'delete'])->name('feed_delete');
            });
        });

        return self::$slimInstance = $app;
    }
}
