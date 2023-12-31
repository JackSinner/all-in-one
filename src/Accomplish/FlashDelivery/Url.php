<?php

namespace Library\Europe\Accomplish\FlashDelivery;

class Url
{
    //订单计费
    const ORDER_CALCULATE_URI = 'https://open.ishansong.com/openapi/merchants/v5/orderCalculate';

    //提交订单
    const ORDER_PLACE_URI = 'https://open.ishansong.com/openapi/merchants/v5/orderPlace';

    //查询账号额度
    const GET_USER_ACCOUNT_URI = 'https://open.ishansong.com/openapi/merchants/v5/getUserAccount';

    //修改收件人手机号
    const UPDATE_TO_MOBILE_URI = 'https://open.ishansong.com/openapi/merchants/v5/updateToMobile';

    //订单取消
    const ABORT_ORDER_URI = 'https://open.ishansong.com/openapi/merchants/v5/abortOrder';

    //确认送回
    const CONFIRM_GOODS_RETURN_URI = 'https://open.ishansong.com/openapi/merchants/v5/confirmGoodsReturn';
}