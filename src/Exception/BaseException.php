<?php

namespace Library\Europe\Exception;

class BaseException extends \Exception
{
    private int $throwType = 0;

    /**
     * curl 请求异常
     */
    const THROW_TYPE_HTTP_REQUEST = 0;

    /**
     * 微信请求后的返回异常
     */
    const THROW_TYPE_WECHAT = 1;

    protected function setThrowType(int $throwType = 0): self
    {
        $this->throwType = $throwType;
        return $this;
    }

    public function getThrowType(): int
    {
        return $this->throwType;
    }
}