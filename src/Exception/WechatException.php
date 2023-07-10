<?php

namespace Library\Europe\Exception;

use Throwable;

class WechatException extends BaseException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->setThrowType(BaseException::THROW_TYPE_WECHAT);
        parent::__construct($message, $code, $previous);
    }
}