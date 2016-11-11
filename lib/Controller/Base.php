<?php

namespace Controller;

use \Slim\Slim as Slim;

abstract class Base
{
    protected $app;

    /**
     * Create object
     */
    public function __construct(Slim $app)
    {
        $this->app = $app;

        return $this;
    }

    /**
     *  Auto redefined Slim methods to Controller class.
     *      @see        Magic methods in PHP
     *      @param      string      $method     - method name
     *      @param      array       $arguments  - arguments list
     *      @return     mix                     - result of calling Slim '$method'
     */
    public function __call($method, $arguments)
    {
        $app = $this->app;

        if (method_exists($app, $method)) {
            return call_user_func_array(array(&$app, $method), $arguments);
        }
    }

    /**
     *  void renderJson( $json )   - print JSON string
     *      @param      array       $data   - json structure
     *      @param      string      $type   - content-type header (default 'application/json')
     *      @return     void
     */
    public function renderJson($data, $type = 'application/json')
    {
        $this->response()->header('Content-Type', $type);
        $this->response()->write(json_encode($data), 'replace');
        $this->stop();
    }

    public function renderFile($data = [])
    {
        $file = __DIR__.'/../../storage/formData/'.$data['File'];
        $size = filesize($file);
        header("Content-Description: File Transfer");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename={$data['Filename']}");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: public");
        header("Cache-Control: must-revalidate");
        header("Content-Length: {$size}");

        ob_clean();
        flush();
        readfile($file);
        $content = ob_get_clean();
        $this->response()->body($content);
        $this->stop();
    }

    /**
     *  Object log() - return log property for Slim object. It was defined in RestAPI script
     */
    public function log()
    {
        return $this->app->log;
    }

    public function config()
    {
        return $this->app->config;
    }

    public function userIp()
    {
        return $this->app->request()->getIp();
    }

    public function userAgent()
    {
        return $this->app->request()->getUserAgent();
    }

    /**
     * mix run( function $cb, bool $isSkipSuccessRender ) - action wrapper
     */
    public function run($cb, $isSkipSuccessRender = null, $file = false)
    {
        try {
            $result = call_user_func($cb);

            if ($isSkipSuccessRender) {
                return $result;
            } elseif ($file) {
                $this->renderFile($result);
            } else {
                $this->renderJSON($result);
            }
        } catch (\Service\X $e) {
            if ($isSkipSuccessRender) {
                return $e->getError();
            } else {
                $this->renderJson($e->getError());
            }
        } catch (\Service\X\WrongAuthorization $e) {
            $this->renderJson($e->getError());
        }
    }

    /**
     * mix action( string $class ) - create service object
     */
    public function action($class)
    {
        return new $class([
            'UserId'    => (isset($_SESSION['UserId']) ? $_SESSION['UserId'] : null),
            'log'       => $this->log(),
            'config'    => $this->config(),
            'Ip'        => $this->userIp(),
            'UserAgent' => $this->userAgent(),
        ]);
    }
}
