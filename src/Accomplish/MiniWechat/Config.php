<?php

namespace Library\Europe\Accomplish\MiniWechat;

use Library\Europe\Accomplish\BaseConfig;

class Config extends BaseConfig
{

    public string $appId;
    public string $secret;

    /**
     * @param string $appId 小程序appId
     * @param string $secret 小程序密钥
     */
    public function __construct(string $appId, string $secret)
    {
        $this->appId = $appId;
        $this->secret = $secret;
    }
}