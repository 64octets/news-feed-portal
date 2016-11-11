<?php

namespace Service;

abstract class Base
{
    use Utils;

    private $log;
    private $config;
    private $UserId;
    private $Ip;
    private $UserAgent;

    public function __construct($attrs)
    {
        if (isset($attrs['log'])) {
            $this->log = $attrs['log'];
        }
        if (isset($attrs['config'])) {
            $this->config = $attrs['config'];
        }
        if (isset($attrs['UserId'])) {
            $this->UserId = $attrs['UserId'];
        }
        if (isset($attrs['Ip'])) {
            $this->Ip = $attrs['Ip'];
        }
        if (isset($attrs['UserAgent'])) {
            $this->UserAgent = $attrs['UserAgent'];
        }
    }

    protected function log()
    {
        return $this->log;
    }

    protected function config()
    {
        return $this->config;
    }

    protected function output($msg)
    {
        error_log(print_r($msg, 1));
    }

    protected function dataFetcher()
    {
        return $this->dataFetcher;
    }

    protected function getUserId()
    {
        return $this->UserId;
    }

    protected function getUser()
    {
        return \Engine\UsersQuery::create()->filterById($this->getUserId())->findOne();
    }

    protected function getUserIp()
    {
        return $this->Ip;
    }

    protected function getUserAgent()
    {
        return $this->UserAgent;
    }

    public function run($params = [])
    {
        try {
            $validated = $this->validate($params);
            $result = $this->execute($validated);

            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
