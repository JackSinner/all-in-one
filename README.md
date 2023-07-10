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

### 微信小程序使用方式

```php
use Library\Europe\Accomplish\MiniWechat\MiniWechat;
use Library\Europe\Exception\BaseException;
$object = MiniWechat::instance()->setConfig(
    array(
      'app_id' => 'xxxx',//微信小程序app id
      'secret' => 'xxxxxxx',//微信小程序密钥
    )
);
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

```php

```