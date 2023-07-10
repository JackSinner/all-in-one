<?php

namespace Library\Europe\Exception;

use Throwable;

class FourPayException extends BaseException
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->setThrowType(BaseException::THROW_TYPE_FOUR_PAY);
        parent::__construct($message, $code, $previous);
    }
}