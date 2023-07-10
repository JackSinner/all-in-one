<?php

namespace Library\Europe\Interfaces\Sms;

interface SmsInterface
{
    /**
     * 发送短信
     * @param string $phone
     * @param string|array $content
     * @return bool|string 返回true为发送成功,返回字符串为发送失败,字符串为失败信息
     */
    public function send(string $phone, $content);

    /**
     * 获取单例
     */
    public static function instance(): object;

    /**
     * 获取签名数据
     * @param array|string|int|mixed $data 签名需要的参数
     * @return string
     */
    public function getSign($data): string;
}