<?php

namespace Library\Europe\Accomplish\FlashDelivery;

class Url
{
    //订单计费
    const ORDER_CALCULATE_URI = 'http://open.s.bingex.com/openapi/merchants/v5/orderCalculate';

    //提交订单
    const ORDER_PLACE_URI = 'http://open.s.bingex.com/openapi/merchants/v5/orderPlace';

    //查询账号额度
    const GET_USER_ACCOUNT_URI = 'http://open.s.bingex.com/openapi/merchants/v5/getUserAccount';
}