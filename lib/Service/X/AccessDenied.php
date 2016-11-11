<?php

namespace Service\X;

/**
 *  @class \Service\X\AccessDenied
 *
 */

class AccessDenied extends \Service\X
{
    protected $type = 'ACCESS_DENIED';

    public function getError()
    {
        return [
            'error' => [
                'type' => $this->type,
            ]
        ];
    }
}
