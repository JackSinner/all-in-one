<?php

namespace Library\Europe\Accomplish\FlashDelivery\Options;

use Library\Europe\Accomplish\BaseConfig;

class OrderCalculateOption extends BaseConfig
{

    //立即单
    const APPOINT_TYPE_NOW = 0;

    //预约单
    const APPOINT_TYPE_RESERVE = 1;

    public string $cityName;
    public int $appointType;
    public SenderOption $sender;
    public ReceiverListOption $receiverList;
    public ?string $appointmentDate;

    public function __construct(string $cityName, int $appointType, SenderOption $sender, ReceiverListOption $receiverList, ?string $appointmentDate = null)
    {
        $this->cityName = $cityName;
        $this->appointType = $appointType;
        $this->sender = $sender;
        $this->receiverList = $receiverList;
        $this->appointmentDate = $appointmentDate;
    }
}

