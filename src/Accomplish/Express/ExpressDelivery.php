<?php

namespace Library\Europe\Accomplish\Express;

use Library\Europe\Accomplish\AccomplishAbsClass;
use Library\Europe\Exception\ExpressException;

/**
 * @property Config $config
 */
class ExpressDelivery extends AccomplishAbsClass
{
    /**
     * @param string $companyCode 快递公司code
     * @param string $orderNo 快递订单号
     * @param string|null $senderPhone 接收人或者寄件人手机号码
     * @return mixed
     * @throws ExpressException
     * @throws \Library\Europe\Exception\HttpRequestException
     */
    public function syncQuery(string $companyCode, string $orderNo, ?string $phone = null)
    {
        if (in_array($companyCode, ['shunfeng', 'shunfengkuaiyun']) && is_null($phone)) {
            throw new ExpressException('请填写寄件人电话');
        }
        $params = json_encode([
            'com' => $companyCode,
            'num' => $orderNo,
            'phone' => '',
            'from' => '',
            'to' => '',
            'resultv2' => '',
            'show' => Config::RESULT_JSON,
            'order' => 'desc',
        ]);
        if (!is_null($phone)) {
            $params['phone'] = $phone;
        }
        $data = [
            'customer' => $this->config->customer,
            'sign' => $this->sign($params),
            'param' => $params,
        ];
        $res = $this->post(Url::SYNC_QUERY_URI . '?' . $this->eachBuildQuery($data), $this->buildXWWWFormUrlEncodeHeader());
        if ($res['status'] != Config::RESULT_STATUS_OK) {
            throw new ExpressException($res['message']);
        }
        return $res;
    }


    public function subscription(string $companyCode, string $orderNo, string $callbackurl, ?string $phone = null)
    {
        if (in_array($companyCode, ['shunfeng', 'shunfengkuaiyun']) && is_null($phone)) {
            throw new ExpressException('请填写寄件人电话');
        }
        $param = json_encode(array(
            'company' => $companyCode,
            'number' => $orderNo,
            'from' => '',
            'to' => '',
            'key' => $this->config->key,
            'parameters' => array(
                'callbackurl' => $callbackurl,
                'salt' => '',
                'resultv2' => '',
                'autoCom' => '',
                'interCom' => '',
                'departureCountry' => '',
                'departureCom' => '',
                'destinationCountry' => '',
                'destinationCom' => '',
                'phone' => '',
            ),
        ));
        if (!is_null($phone)) {
            $param['parameters']['phone'] = $phone;
        }
        $data = [
            'schema' => 'json',
            'param' => $param,
        ];
        $res = $this->post(Url::SUBSCRIPTION_URI . '?' . $this->eachBuildQuery($data), $this->buildXWWWFormUrlEncodeHeader());
        if (!$res['result']) {
            throw new ExpressException($res['message']);
        }
        return true;
    }


    private function sign(string $param): string
    {
        return strtoupper(md5($param . $this->config->key . $this->config->customer));
    }
}
