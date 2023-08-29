<?php

namespace Library\Europe\Accomplish\FourPay;

use Library\Europe\Accomplish\BaseConfig;

class Config extends BaseConfig
{

    public string $merchant;

    public string $key;

    public string $channel;

    public string $passCode;

    public string $payNoticeUrl;

    public string $refundNoticeUrl;

    public string $member;

    /**
     * @param string $merchant 商户编号
     * @param string $key 密钥
     * @param string $channel 支付通道
     * @param string $passCode 通道code
     * @param string $payNoticeUrl 支付回调地址
     * @param string $refundNoticeUrl 退款回调地址
     */
    public function __construct(string $merchant, string $key, string $channel, string $passCode, string $payNoticeUrl, string $refundNoticeUrl)
    {
        $this->merchant = $merchant;
        $this->key = $key;
        $this->channel = $channel;
        $this->passCode = $passCode;
        $this->payNoticeUrl = $payNoticeUrl;
        $this->refundNoticeUrl = $refundNoticeUrl;
    }

}