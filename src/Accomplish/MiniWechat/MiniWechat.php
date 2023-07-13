<?php

namespace Library\Europe\Accomplish\MiniWechat;

use Library\Europe\Accomplish\AccomplishAbsClass;
use Library\Europe\Exception\WechatException;

/**
 * @property Config $config
 */
class MiniWechat extends AccomplishAbsClass
{

    /**
     * 通过微信小程序jscode获取用户在微信的唯一标识
     * @param string $jsCode
     * @return mixed
     * @throws WechatException
     * @throws \Library\Europe\Exception\HttpRequestException
     */
    public function code2session(string $jsCode)
    {
        $result = $this->get(Url::CODE_2_SESSION_URI, array(
            'appid' => $this->config->appId,
            'secret' => $this->config->secret,
            'js_code' => $jsCode,
            'grant_type' => 'authorization_code',
        ));
        if (isset($result["errcode"]) && $result["errcode"] != 0) {
            throw new WechatException($result["errmsg"], $result['errcode']);
        }
        return $result;
    }
}