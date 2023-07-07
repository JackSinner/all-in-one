<?php

namespace Library\Europe\Accomplish\FusionCloud;

class Url
{
    //发送模板短信接口,模板审核一次后,后面就可以立即发送出去
    const SEND_SMS_TP = 'https://api.mix2.zthysms.com/v2/sendSmsTp';

    //自定义短信发送接口,缺点:每次发送需要人工审核短信内容后才能发送出去
    const SEND_SMS_CUSTOM = 'https://api.mix2.zthysms.com/v2/sendSms';
}