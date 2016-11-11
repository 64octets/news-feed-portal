<?php

/*------------------------------------------------------------------------------+
|                  Basic abstract class for building cronjob                    |
+-------------------------------------------------------------------------------+
|                            *** cronjob.php ***                                |
| <?php                                                                         |
|                                                                               |
| $script = new Scripts\YourScript('loggerName', 'pidfile.pid');                |
| $script->run();                                                               |
|                                                                               |
|                            *** YourScript.php ***                             |
| <?php                                                                         |
|                                                                               |
| class YourScript extends \Script                                              |
| {                                                                             |
|      public function main()                                                   |
|      {                                                                        |
|           // your code                                                        |
|                                                                               |
|      }                                                                        |
| }                                                                             |
+------------------------------------------------------------------------------*/
namespace {

    abstract class Script
    {
        protected $log;
        protected $pidPath;
        protected $loggerPath;
        protected $config = [];

        public function __construct($loggerPath, $pidPath)
        {
            $this->config = require(__DIR__.'/../etc/app-conf.php');
            $propel = require(__DIR__.'/../etc/propel.php');
            Engine::init($propel['propel']['database']['connections']);
            $this->pidPath = $pidPath;
            $this->loggerPath = $loggerPath;
            $this->log = new \Monolog\Logger($loggerPath);
            $this->log->pushHandler(
                new \Monolog\Handler\StreamHandler(__DIR__.'/../logs/'.$loggerPath.'.log', \Monolog\Logger::DEBUG)
            );
        }

        final public function run()
        {
            $this->start();
            try {
                $this->main();
            } catch (\Service\X $e) {
                error_log(print_r($e->getError(), true));
                $this->log
                    ->error("ERROR: Caught Exception in script {$this->loggerPath} with message: {$e->getMessage()}");
            } catch (\Exception $e) {
                error_log(print_r($e, true));
                $this->log
                    ->error("ERROR: Caught Exception in script {$this->loggerPath} with message: {$e->getMessage()}");
            }
            $this->finish();
        }

        /**
         * Start script create PID file
         *
         * @return void nothing to return
         */
        protected function start()
        {
            $this->log->info("START {$this->loggerPath} script");

            $pidFilepath = $this->config['pidDir'] . '/' . $this->pidPath;

            if (file_exists($pidFilepath)) {
                $pid = file_get_contents($pidFilepath);

                if ($this->checkPid((int)$pid)) {
                    $this->log->info('Script already running. PID = ' . $pid);
                    exit();
                } else {
                    $this->log->info('WARN: pid file exists, but process stoped: ' . $pid);
                }
            }

            file_put_contents($pidFilepath, POSIX_getpid());
        }

        private function checkPid($pid)
        {
            return posix_kill($pid, 0);
        }

        /**
         * Finish script and remove PID file
         *
         * @return void nothing to return
         */
        protected function finish()
        {
            $this->log->info("FINISH {$this->loggerPath} script");

            unlink($this->config['pidDir'] . '/' . $this->pidPath);
        }

        /**
         * Function - entry point for script
         *
         * @return void Nothing to return for cron script
         */
        abstract protected function main();

        public function action($class)
        {
            return new $class([
                'log'    => $this->log,
                'config' => $this->config
            ]);
        }
    }
}
