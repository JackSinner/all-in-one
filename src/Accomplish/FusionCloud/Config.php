<?php

namespace Library\Europe\Accomplish\FusionCloud;

use Library\Europe\Accomplish\BaseConfig;

class Config extends BaseConfig
{

    public string $userName;

    public string $password;

    public string $sign;

    public string $tplId;

    /**
     * @param string $userName 用户名
     * @param string $password api密码
     * @param string $sign 短信签名
     * @param string $tplId 短信模板id
     */
    public function __construct(string $userName, string $password, string $sign, string $tplId)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->sign = $sign;
        $this->tplId = $tplId;
    }
}