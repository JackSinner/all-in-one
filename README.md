### 助通融合云短信使用方式

```php
<?php

//获取单例
$object=\Library\Europe\Accomplish\FusionCloud\Sms::instance();

//设置发送方式,发送方式包括1模板短信,2自定义短信。模板短信一次审核后面不用在审核就可以立即发送出短信，
//相反的自定义短信需要每次都审核才会发送短信。

//发送自定义短信实例
$object->setSendType(\Library\Europe\Accomplish\FusionCloud\Sms::SMS_SEND_TYPE_CUSTOM);

//调用send发送短信,send会返回true|string。true为发送成功,如果为string类型,就是失败的原因
$result=$object->send("153xxxxxxx","这是一条测试短信");
if ($result===true){
    return "发送成功";
}else{
    return sprintf("发送失败,失败原因:%s",$result);
}

//发送模板短信实例
$object->setSendType(\Library\Europe\Accomplish\FusionCloud\Sms::SMS_SEND_TYPE_TP);

//发送模板短信的时候,第二个参数为替换的模板变量内容
$result=$object->send('153xxxxxxxx',[
    'code'=>'1234',
]);
if ($result===true){
    return "发送成功";
}else{
    return sprintf("发送失败,失败原因:%s",$result);
}
```