<?php

namespace Library\Europe\Accomplish\FlashDelivery\Options;

use Library\Europe\Accomplish\BaseConfig;

class SenderOption extends BaseConfig
{

    public string $fromAddress;
    public string $fromSenderName;
    public string $fromMobile;
    public string $fromLatitude;
    public string $fromLongitude;
    public string $fromAddressDetail;

    public function __construct(
        string $fromAddress,
        string $fromSenderName,
        string $fromMobile,
        string $fromLatitude,
        string $fromLongitude,
        string $fromAddressDetail
    )
    {
        $this->fromAddress = $fromAddress;
        $this->fromSenderName = $fromSenderName;
        $this->fromMobile = $fromMobile;
        $this->fromLatitude = $fromLatitude;
        $this->fromLongitude = $fromLongitude;
        $this->fromAddressDetail = $fromAddressDetail;
    }
}