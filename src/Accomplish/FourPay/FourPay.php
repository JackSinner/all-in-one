<?php

namespace Library\Europe\Accomplish\FourPay;

use Library\Europe\Accomplish\AccomplishAbsClass;
use Library\Europe\Exception\FourPayException;
use Library\Europe\Exception\HttpRequestException;
use Library\Europe\Interfaces\FourPay\FourPayInterface;

/**
 * @property Config $config
 */
class FourPay extends AccomplishAbsClass implements FourPayInterface
{


    /**
     * 结算卡绑定方式-对私
     */
    const BANK_ACCT_TYPE = 2;

    /**
     * @param array $user 用户信息
     * @param string $orderNo 订单编号
     * @param float $amount 支付金额
     * @param string $title 标题
     * @param string $content 支付详细描述
     * @param array $options 其他参数
     * @return array
     * @throws FourPayException
     * @throws HttpRequestException
     */
    public function gotoPay(
        array  $user,
        string $orderNo,
        float  $amount,
        array  $options = [],
        string $title = 'test payment',
        string $content = 'test payment'
    ): array
    {
        //先入网一次
        $member = $this->register($user['mobile']);
        $this->config->member = $member;
        //发起支付
        $body = [
            'member' => $this->config->member,
            'channel' => $this->config->channel,
            'order_num' => $orderNo,
            'amount' => $amount,
            'pass_code' => $this->config->passCode,
            'title' => $title,
            'body' => $content,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'request_config' => $this->getRequestConfig($user, $this->config->channel, $options),
            'notice_url' => $this->config->noticeUrl,
        ];
        $body['sign'] = $this->getSign($body);
        $result = $this->post(Url::PAY_URI, $body, $this->buildFourPayHeader());
        $code = $result['code'] ?? null;
        if (is_null($code)) {
            throw new FourPayException('请求支付失败');
        } else if ($code != 1) {
            throw new FourPayException($result['msg']);
        }
        return $result['data'];
    }

    private function getRequestConfig(array $user, string $channel, array $options): array
    {
        switch ($channel) {
            case 'wx_lite':
                return [
                    'appid' => $options['app_id'],
                    'openid' => $user['openid'],
                ];
        }
        return [];
    }


    /**
     * @param string $phone 电话号码
     * @param string|null $userName 真实姓名
     * @param string|null $identityNumber 身份证
     * @param array $bank 银行卡信息
     * @return string 返回子商户号
     * @throws FourPayException
     * @throws HttpRequestException
     */
    public function register(
        string  $mobile,
        ?string $userName = null,
        ?string $identityNumber = null,
        array   $bank = []
    ): string
    {
        $body = array(
            'mobile' => $mobile,
        );
        if ($userName) {
            $body['username'] = $userName;
        }
        if ($identityNumber) {
            $body['id_number'] = $identityNumber;
        }
        if ($bank) {
            $bank = array_filter($bank, fn($key) => in_array($key, array(
                'bank_code',
                'phone',
                'card_number',
                'province',
                'city',
                'area',
                'bank_img',
                'ban_id_img',
                'bank_img_b',
            )), ARRAY_FILTER_USE_KEY);
            if (count($bank) != 9) {
                throw new FourPayException('请填写完整的银行信息');
            }
            $body = array_merge($body, $bank);
        }
        $body['sign'] = $this->getSign($body);
        $result = $this->post(Url::REGISTER_URI, $body, $this->buildFourPayHeader());
        $member = $result['data']['member'] ?? null;
        if (!$member) {
            throw new FourPayException('获取子商户号失败');
        }
        return $member;
    }

    private function buildFourPayHeader(): array
    {
        return array(
            'merchant:' . $this->config->merchant,
            'Content-Type:application/json'
        );
    }

    public function getSign(array $params): string
    {
        ksort($params);
        $str = json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return md5($str . $this->config->key);
    }

    public function bindSettlementCard(string $member, string $cardName, string $certId, string $cardId, string $telNo, int $bankAcctType = 2): array
    {
        if ($bankAcctType != 2) {
            throw new FourPayException('还不支持绑定企业银行卡');
        }
        $body = [
            'member' => $member,
            'pass_code' => $this->config->passCode,
            'bank_acct_type' => $bankAcctType,
            'card_id' => $cardId,
            'tel_no' => $telNo,
            'card_name' => $cardName,
            'cert_id' => $certId,
        ];
        $body['sign'] = $this->getSign($body);
        $res = $this->post(Url::BIND_SETTLEMENT_CARD_URI, $body, $this->buildFourPayHeader());
        if (!isset($res['code'])) {
            throw new \Exception('系统错误');
        } else if ($res['code'] != 1) {
            //返回了错误
            throw new FourPayException($res['msg']);
        }
        return $res['data'];
    }
}