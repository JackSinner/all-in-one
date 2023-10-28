<?php

namespace Library\Europe\Accomplish\Express;

use Library\Europe\Accomplish\BaseConfig;

class Config extends BaseConfig
{

    public string $customer;
    public string $intelligent_judgment;
    public string $key;
    public string $secret;
    public string $userid;


    const RESULT_JSON = 0;

    const RESULT_XML = 1;

    const RESULT_HTML = 2;

    const RESULT_TEXT = 3;

    const RESULT_STATUS_OK = 200;

    public function __construct(string $customer, string $key, string $secret, string $userid, string $intelligent_judgment)
    {
        $this->customer = $customer;
        $this->key = $key;
        $this->secret = $secret;
        $this->userid = $userid;
        $this->intelligent_judgment = $intelligent_judgment;
    }
}