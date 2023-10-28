<?php

namespace Library\Europe\Exception;

use Throwable;

class ExpressException extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->setThrowType(BaseException::THROW_TYPE_FLASH_DELIVERY);
        parent::__construct($message, $code, $previous);
    }
}