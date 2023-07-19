<?php

namespace Library\Europe\Accomplish\IpyySms;

use Library\Europe\Accomplish\AccomplishAbsClass;
use Library\Europe\Exception\IpyySmsException;
use Library\Europe\Interfaces\Sms\SmsInterface;

/**
 * @property Config $config
 */
class IpyySms extends AccomplishAbsClass implements SmsInterface
{

    /**
     * @param string $phone
     * @param string $content 验证码
     * @return bool|mixed|string
     * @throws IpyySmsException
     * @throws \Library\Europe\Exception\HttpRequestException
     */
    public function send(string $phone, $content)
    {
        $data = [
            'userid' => '1',
            'account' => $this->config->user_name,
            'password' => $this->getSign(""),
            'mobile' => $phone,
            'content' => sprintf("【%s】您的验证码是：%s，有效期为5分钟。如非本人操作，可不予理会。", $this->config->sign, $content),
            'action' => 'send',
            'sendTime' => ''
        ];
        $res = $this->get(Url::SEND_SMS_API, $data);
        if (!isset($res['returnstatus'])) {
            throw new \Exception("系统错误");
        } else if (strtolower($res['returnstatus']) == 'returnstatus') {
            throw new IpyySmsException($res['message']);
        }
        return $res;
    }

    public function getSign($data): string
    {
        return strtoupper(md5($this->config->user_pass));
    }
}