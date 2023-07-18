<?php

namespace Library\Europe\Interfaces\FourPay;

interface FourPayInterface
{
    /**
     * 发起支付
     * @param array $user
     * @param string $orderNo
     * @param float $amount
     * @param array $options
     * @param string $title
     * @param string $content
     * @return array
     */
    public function gotoPay(array $user, string $orderNo, float $amount, array $options = [], string $title = 'test payment', string $content = 'test payment'): array;

    /**
     * 注册
     * @param string $mobile
     * @param string|null $userName
     * @param string|null $identityNumber
     * @param array $bank
     * @return string
     */
    public function register(string $mobile, ?string $userName = null, ?string $identityNumber = null, array $bank = []): string;

    /**
     * 绑定结算卡(todo 目前只实现了个人绑定卡)
     * @param string $member 会员号
     * @param string $cardName 银行卡绑定的真实姓名
     * @param string $certId 身份证号
     * @param string $cardId 银行卡卡号
     * @param string $telNo 联系电话
     * @param int $bankAcctType 绑定结算卡类型1=对公,2=对私
     * @return mixed
     */
    public function bindSettlementCard(string $member, string $cardName, string $certId, string $cardId, string $telNo, int $bankAcctType = 2): array;
}