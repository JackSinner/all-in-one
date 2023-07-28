### 怎么安装

#### 写入以下内容到你的composer.json文件里

```json
{
  "require": {
    //...
    "library/europe": "v0.0.1"
  },
  //...
  "repositories": [
    {
      "type": "vcs",
      //如果你的git账号有@符号,使用%40代替
      "url": "https://{你的git账号}:{你的git密码}@gitee.com/scoq/composer.git"
    }
  ]
}

修改以上内容到你的comopser.json后,如果存在composer.lock文件请使用composer update 来更新依赖包
如果不存在composer.lock文件使用composer install 来安装依赖包
```

### 助通融合云短信使用方式

```php
<?php
use \Library\Europe\Accomplish\FusionCloud\Sms;
use \Library\Europe\Accomplish\FusionCloud\Config;
//获取单例
$object=Sms::instance()->setConfig(new Config("user_name","password","签名","213"));

//设置发送方式,发送方式包括1模板短信,2自定义短信。模板短信一次审核后面不用在审核就可以立即发送出短信，
//相反的自定义短信需要每次都审核才会发送短信。

//发送自定义短信实例
$object->setSendType(Sms::SMS_SEND_TYPE_CUSTOM);

//调用send发送短信,send会返回true|string。true为发送成功,如果为string类型,就是失败的原因
$result=$object->send("153xxxxxxx","这是一条测试短信");
if ($result===true){
    return "发送成功";
}else{
    return sprintf("发送失败,失败原因:%s",$result);
}

//发送模板短信实例
$object->setSendType(Sms::SMS_SEND_TYPE_TP);

//发送模板短信的时候,第二个参数为替换的模板变量内容
$result=$object->send('153xxxxxxxx',[
    'code'=>'1234',//需要替换模板的变量
]);
if ($result===true){
    return "发送成功";
}else{
    return sprintf("发送失败,失败原因:%s",$result);
}
```

### 微信小程序使用方式

```php
use Library\Europe\Accomplish\MiniWechat\MiniWechat;
use Library\Europe\Exception\BaseException;
use \Library\Europe\Accomplish\MiniWechat\Config;

$object = MiniWechat::instance()->setConfig(new Config('小程序appid','小程序密钥'));
try {
    $sessionInfo = $object->code2session($post['js_code']);
}catch (\Exception $exception){
    if ($exception instanceof BaseException) {
          switch ($exception->getThrowType()) {
              case BaseException::THROW_TYPE_HTTP_REQUEST:
                  //http请求微信错误
              case BaseException::THROW_TYPE_WECHAT:
                  //http请求后微信返回错误
              default:
                  //其他错误
          }
    } else {
         // more exception           
    }
}
```


### 四方支付

#### 目前只支持微信小程序支付

```php
 use Library\Europe\Accomplish\FourPay\FourPay;
 use \Library\Europe\Accomplish\FourPay\Config;
 $pay = FourPay::instance()->setConfig(new Config(
    "商户id",
    "商户key",
    "wx_lite",//微信小程序支付
    "F4-104",
    "回调地址",
 ));
 try {
     $data = $pay->gotoPay(
         [
            'mobile' => '131xxxxxxxx',//手机号码
            'openid' => 'xxxxxx',//微信小程序open_id
         ],
         'four_pay_20xxxxxxx',//自己平台的订单号
         0.01,//支付金额
         [
             'app_id' => 'xxxxxx',//微信appid
         ]
     );
 } catch (\Exception $exception) {
    //..错误处理
    
 }
```

### ipyy发送短信

```php
 use \Library\Europe\Accomplish\IpyySms\IpyySms;
 use \Library\Europe\Accomplish\IpyySms\Config;
 try {
    $object = IpyySms::instance()->setConfig(new Config(
        'user_name',//账号
        'user_pass',//短信密码
        'sign'//签名
    ));
    $res = $object->send('153xxxxxxxx','5141');
 }catch (\Exception $exception){
    //..错误处理
 }
```

### 闪送

```php
use \Library\Europe\Accomplish\FlashDelivery\FlashDelivery;
use \Library\Europe\Accomplish\FlashDelivery\Options\OrderCalculateOption;
use \Library\Europe\Accomplish\FlashDelivery\Options\SenderOption;
use \Library\Europe\Accomplish\FlashDelivery\Options\ReceiverListOption;
use \Library\Europe\Accomplish\FlashDelivery\Config;
try {
    $object = FlashDelivery::instance()->setConfig(new Config(
        '2000xxxxxxxxxxx',
        'ssfxxxxxxxxxUzU',
        '98fxxxxxxxxxxxxxxxxxc1zHw1I',
    ));
    $res = $object->orderCalculate(new OrderCalculateOption(
        '成都市',//城市
        OrderCalculateOption::APPOINT_TYPE_NOW,//立即送
        new SenderOption(//寄件信息
            $data['fromAddress'],
            $data['fromSenderName'],
            $data['fromMobile'],
            $data['fromLatitude'],
            $data['fromLongitude'],
        ),
        new ReceiverListOption(//收件信息
            $order['order_no'],
            $data['toAddress'],
            $data['toReceiverName'],
            $data['toMobile'],
            $data['goodType'],
            $data['weight'],
            $data['toLatitude'],
            $data['toLongitude'],
        ),
    ));
}catch (\Exception $exception){
    //..错误处理
}
```