<?php

namespace Library\Europe\Accomplish\FlashDelivery\Options;

use Library\Europe\Accomplish\BaseConfig;

class ReceiverListOption extends BaseConfig
{

    public string $orderNo;
    public string $toAddress;
    public string $toReceiverName;
    public string $toMobile;
    public int $goodType;
    public int $weight;
    public string $toLatitude;
    public string $toLongitude;
    public ?string $toAddressDetail = null;

    public function __construct(
        string  $orderNo,
        string  $toAddress,
        string  $toReceiverName,
        string  $toMobile,
        int     $goodType,
        int     $weight,
        string  $toLatitude,
        string  $toLongitude,
        ?string $toAddressDetail = null
    )
    {
        $this->orderNo = $orderNo;
        $this->toAddress = $toAddress;
        $this->toReceiverName = $toReceiverName;
        $this->toMobile = $toMobile;
        $this->goodType = $goodType;
        $this->weight = $weight;
        $this->toLatitude = $toLatitude;
        $this->toLongitude = $toLongitude;
        $this->toAddressDetail = $toAddressDetail;
    }
}