<?php

namespace Library\Europe\Accomplish\FusionCloud;

use Library\Europe\Accomplish\AccomplishAbsClass;
use Library\Europe\Interfaces\Sms\SmsInterface;

class Sms extends AccomplishAbsClass implements SmsInterface
{

    //发送模板短信
    const SMS_SEND_TYPE_TP = 1;

    //自定义短信
    const SMS_SEND_TYPE_CUSTOM = 2;

    protected int $type = self::SMS_SEND_TYPE_TP;


    /**
     * 设置发送短信的方式
     * @param int $type
     * @return $this
     */
    final public function setSendType(int $type = Sms::SMS_SEND_TYPE_TP): self
    {
        $this->type = $type;
        return $this;
    }

    final private function sendTp(string $phone, array $content)
    {
        $userName = $this->platform->getConfig('user_name');
        if (!$userName) {
            throw new \Exception('账号未配置');
        }
        $sign = $this->platform->getConfig('sign');
        if (!$sign) {
            throw new \Exception('短信签名未配置');
        }
        $tplId = $this->platform->getConfig('tpl_id');
        if (!$tplId) {
            throw new \Exception('模板id未设置');
        }
        $body = array_merge(array(
            'signature' => sprintf("【%s】", $sign),
            'tpId' => $tplId,
            'records' => [
                array(
                    'mobile' => $phone,
                    'tpContent' => $content,
                )
            ],
        ), $this->getCommonParams());
        $res = $this->post(Url::SEND_SMS_TP, $body, $this->buildJsonHeader());
        if (!isset($res['code'])) {
            return "请求发送短信失败";
        } else if ($res['code'] == Status::SEND_CODE_SUCCESS) {
            return true;
        } else {
            return $res['msg'];
        }
    }

    /**
     * 获取公共给的提交参数
     * @return array
     * @throws \Exception
     */
    final private function getCommonParams(): array
    {
        $userName = $this->platform->getConfig('user_name');
        if (!$userName) {
            throw new \Exception("账号未配置");
        }
        $password = $this->platform->getConfig('password');
        if (!$password) {
            throw new \Exception('密钥未配置');
        }
        $now = time();
        $sign = $this->getSign($now);
        return [
            'username' => $userName,
            'password' => $sign,
            'tKey' => $now,
        ];
    }

    final private function sendCustomSms(string $phone, string $content)
    {
        $sign = $this->platform->getConfig('sign');
        if (!$sign) {
            throw new \Exception('短信签名未设置');
        }
        $body = array_merge(array(
            'mobile' => $phone,
            'content' => sprintf("【%s】%s", $sign, $content),
        ), $this->getCommonParams());
        $res = $this->post(Url::SEND_SMS_CUSTOM, $body, self::buildJsonHeader());
        if (!isset($res['code'])) {
            return "请求发送短信失败";
        } else if ($res['code'] == Status::SEND_CODE_SUCCESS) {
            return true;
        } else {
            return $res['msg'];
        }
    }

    public function send(string $phone, $content)
    {
        if ($this->type == self::SMS_SEND_TYPE_TP) {
            return $this->sendTp($phone, $content);
        } else if ($this->type == self::SMS_SEND_TYPE_CUSTOM) {
            return $this->sendCustomSms($phone, $content);
        }
        return false;
    }

    public function getSign($timestamp): string
    {
        $password = $this->platform->getConfig('password');
        return md5(md5($password) . $timestamp);
    }
}