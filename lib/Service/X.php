<?php

namespace Service;

/**
 *  @class \Service\X
 *
 */
class X extends \Exception
{
    protected $fields;
    protected $type;
    protected $message = '';

    public function __construct($attrs = [])
    {
        if (isset($attrs['Message'])) {
            $this->message = $attrs['Message'];
        }

        if (isset($attrs['Fields'])) {
            $this->fields = $attrs['Fields'];
        }

        if (isset($attrs['Type'])) {
            $this->type = $attrs['Type'];
        }
    }

    public function getError()
    {
        $return = [
            'Error' => [
                'Fields'  => $this->fields,
                'Type'    => $this->type,
                'Message' => $this->message,
            ]
        ];
        return $return;
    }
}
