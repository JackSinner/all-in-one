<?php

namespace Library\Europe\Accomplish\FlashDelivery;

use Library\Europe\Accomplish\AccomplishAbsClass;
use Library\Europe\Accomplish\FlashDelivery\Options\OrderCalculateOption;

/**
 * @property Config $config
 */
class FlashDelivery extends AccomplishAbsClass
{

    public function orderCalculate(OrderCalculateOption $option)
    {

    }

    public function buildHeaders(): array
    {
        return array(
            'Content-Type:application/x-www-form-urlencoded',
        );
    }

    private function getSign(array $data, int $timestamp): string
    {
        $data = array_filter($data, fn($key, $value) => $value, ARRAY_FILTER_USE_BOTH);
        ksort($data);
        $str = sprintf("%sclientId%s", $this->config->app_secret, $this->config->client_id);
        if ($data) {
            $str = sprintf("%sdata%s", $str, json_encode($data));
        }
        return strtoupper(md5(sprintf("%sshopId%stimestamp%s", $str, $this->config->shop_id, $timestamp)));
    }
}