<?php

namespace Library\Europe\Platform;

use think\App;

class Platform
{
    //当前环境,默认php原生
    private int $platform = 0;

    //thinkphp环境
    const ENV_THINKPHP_PLATFORM = 1;

    public function __construct()
    {
        //判断是什么环境
        if (class_exists(App::class)) {
            //thinkphp
            $this->platform = self::ENV_THINKPHP_PLATFORM;
        }//。。。还有更多环境
    }

    /**
     * 返回当前的平台
     * @return int
     */
    public function getPlatform(): int
    {
        return $this->platform;
    }
}