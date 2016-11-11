<?php

class LocalWebTestCase extends \There4\Slim\Test\WebTestCase
{
    public function setup()
    {
        \Propel\Runtime\Propel::disableInstancePooling();
        parent::setup();
    }

    public function enablePooling()
    {
        \Propel\Runtime\Propel::enableInstancePooling();
    }

    public function disablePooling()
    {
        \Propel\Runtime\Propel::disableInstancePooling();
    }
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    public static function setUpBeforeClass()
    {
        \Propel\Runtime\Propel::getConnection()->beginTransaction();
    }

    public static function tearDownAfterClass()
    {
        \Propel\Runtime\Propel::getConnection()->rollback();
    }

    public function getSlimInstance()
    {
        $conf = include __DIR__ . '/../etc/app-conf.php';
        return \AppFactory::create($conf);
    }

    public function assertLIVR($data, $livr, $params = array())
    {
        $validator = new \Validator\LIVR($livr);

        $validated = $validator->validate($data);
        $errors    = $validator->getErrors();

        if ($errors) {
            throw new \Exception(
                "Failed asserting by LIVR rules. " .
                (count($params) ? "Params: " . print_r($params, 1) : '') .
                "Errors: ".print_r($errors, 1) .
                ", data: ".print_r($data, 1)
            );
        }

        return $validated;
    }

    public function getWithHeaderAccessToken($url, $params = [])
    {
        $app = $this->getSlimInstance();
        $tokenConf = $app->config['headerAccessToken'];
        $this->client = new There4\Slim\Test\WebTestClient($app);
        $this->client->get(
            $url,
            $params,
            [ $tokenConf['name'] => $tokenConf['values']['NEWSFEED'] ]
        );
    }

    public function postWithHeaderAccessToken($url, $params = [])
    {
        $app = $this->getSlimInstance();
        $tokenConf = $app->config['headerAccessToken'];
        $this->client = new There4\Slim\Test\WebTestClient($app);
        $this->client->post(
            $url,
            $params,
            [ $tokenConf['name'] => $tokenConf['values']['NEWSFEED'] ]
        );
    }

    public function post($url, $params = [])
    {
        $app = $this->app;
        $this->client = new There4\Slim\Test\WebTestClient($this->getSlimInstance());
        $this->login();
        $this->client->post($url, $params);
    }

    public function get($url, $params = [])
    {
        $app = $this->app;
        $this->client = new There4\Slim\Test\WebTestClient($this->getSlimInstance());
        $this->login();
        $this->client->get($url, $params);
    }

    public function delete($url)
    {
        $app = $this->app;
        $this->client = new There4\Slim\Test\WebTestClient($this->getSlimInstance());
        $this->login();
        $this->client->delete($url);
    }

    public function login()
    {
        $_SESSION['UserId'] = 1;
    }
}
