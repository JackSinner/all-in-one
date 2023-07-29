<?php

namespace Library\Europe\Accomplish\FlashDelivery;

use Library\Europe\Accomplish\AccomplishAbsClass;
use Library\Europe\Accomplish\FlashDelivery\Options\OrderCalculateOption;
use Library\Europe\Exception\FlashDeliverException;

/**
 * @property Config $config
 */
class FlashDelivery extends AccomplishAbsClass
{

    /**
     * 计算订单费用
     * @param OrderCalculateOption $option
     * @return mixed
     * @throws FlashDeliverException
     * @throws \Library\Europe\Exception\HttpRequestException
     */
    public function orderCalculate(OrderCalculateOption $option)
    {
        $body = $option->toArray();
        $res = $this->post(Url::ORDER_CALCULATE_URI, $this->buildBody($body), $this->buildHeaders());
        if (!isset($res['status'])) {
            throw new \Exception("系统错误");
        } else if ($res['status'] != 200) {
            throw new FlashDeliverException($res['msg']);
        }
        return $res['data'];
    }

    /**
     * 提交订单
     * @param string $issOrderNo 闪送订单编号
     * @return mixed
     * @throws FlashDeliverException
     * @throws \Library\Europe\Exception\HttpRequestException
     */
    public function orderPlace(string $issOrderNo)
    {
        $res = $this->post(Url::ORDER_PLACE_URI, $this->buildBody(['issOrderNo' => $issOrderNo]), $this->buildHeaders());
        if (!isset($res['status'])) {
            throw new \Exception("系统错误");
        } else if ($res['status'] != 200) {
            throw new FlashDeliverException($res['msg']);
        }
        return $res['data'];
    }

    /**
     *
     * @return mixed
     * @throws FlashDeliverException
     * @throws \Library\Europe\Exception\HttpRequestException
     */
    public function getUserAccount()
    {
        $res = $this->post(Url::GET_USER_ACCOUNT_URI, $this->buildBody([]), $this->buildHeaders());
        if (!isset($res['status'])) {
            throw new \Exception("系统错误");
        } else if ($res['status'] != 200) {
            throw new FlashDeliverException($res['msg']);
        }
        return $res['data'];
    }


    public function buildHeaders(): array
    {
        return array(
            'Content-Type:application/x-www-form-urlencoded',
        );
    }

    private function buildBody(array $params): array
    {
        $now = time();
        $params = array_filter($params, fn($key, $value) => $value, ARRAY_FILTER_USE_BOTH);
        if (is_array($params)) {
            $params = json_encode($params);
        }
        $str = sprintf("%sclientId%s", $this->config->app_secret, $this->config->client_id);
        if ($params) {
            $str = sprintf("%sdata%s", $str, $params);
        }
        $sign = strtoupper(md5(sprintf("%sshopId%stimestamp%s", $str, $this->config->shop_id, $now)));
        return [
            'clientId' => $this->config->client_id,
            'shopId' => $this->config->shop_id,
            'timestamp' => $now,
            'sign' => $sign,
            'data' => $params,
        ];
    }
}