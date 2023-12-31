<?php

namespace Library\Europe\Exception;

use Throwable;

class HttpRequestException extends BaseException
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->setThrowType(BaseException::THROW_TYPE_HTTP_REQUEST);
        parent::__construct($message, $code, $previous);
    }
}