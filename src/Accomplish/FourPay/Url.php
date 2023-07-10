<?php

namespace Library\Europe\Accomplish\FourPay;

class Url
{
    //用户入网,入网后才能支付
    const REGISTER_URI = 'https://pay.dd88.vip/api/index/user_register';

    //支付接口
    const PAY_URI = 'https://pay.dd88.vip/api/index/pay';
}