<?php

namespace Library\Europe\Accomplish\FlashDelivery;

use Library\Europe\Accomplish\BaseConfig;

class Config extends BaseConfig
{

    //测试环境
    const MODEL_TEST_ENV = 0;

    //生产环境
    const MODEL_PROD_ENV = 1;
    public int $model = self::MODEL_PROD_ENV;
    public string $app_secret;
    public string $client_id;
    public string $shop_id;

    public function __construct(string $shop_id, string $client_id, string $app_secret, int $model = self::MODEL_PROD_ENV)
    {
        $this->shop_id = $shop_id;
        $this->client_id = $client_id;
        $this->app_secret = $app_secret;
        $this->model = $model;
    }
}