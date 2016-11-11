<?php

namespace Scripts;

use Propel\Runtime\ActiveQuery\Criteria;

class SyncFeed extends \Script
{
    private $params = [];

    public function __construct($script, array $params)
    {
        parent::__construct($script, "$script.pid");
        $this->params = $params;
    }

    public function main()
    {
        $this->action('Service\Feed\Create')->run($this->params);
    }
}
