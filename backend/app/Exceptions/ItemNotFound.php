<?php

namespace App\Exceptions;

class ItemNotFound extends \Exception
{
    public function __construct($message = 'Item', Throwable $previous = null)
    {
        $this->message = $message . " not found";
        $this->code = -2;
    }
}