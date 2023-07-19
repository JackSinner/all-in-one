<?php

namespace Library\Europe\Accomplish\IpyySms;

use Library\Europe\Accomplish\BaseConfig;

class Config extends BaseConfig
{
    public string $user_name;

    public string $user_pass;

    public string $sign;

    /**
     * @param string $user_name
     * @param string $user_pass
     * @param string $sign
     */
    public function __construct(string $user_name, string $user_pass, string $sign)
    {
        $this->user_name = $user_name;
        $this->user_pass = $user_pass;
        $this->sign = $sign;
    }


}