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

    /**
     * 四方支付异常
     */
    const THROW_TYPE_FOUR_PAY = 2;

    /**
     * ipyy发送短信异常
     */
    const THROW_TYPE_IPPY_SMS = 3;

    /**
     * 闪送异常
     */
    const THROW_TYPE_FLASH_DELIVERY = 4;

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