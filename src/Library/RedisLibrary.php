<?php

namespace Library\Europe\Library;

/**
 * 未实现完,正在实现
 */
class RedisLibrary
{

    private ?\Redis $redis = null;

    public function __construct()
    {
        $this->redis = $this->connect();
    }


    public function connect(): \Redis
    {
//        $redis = new \Redis();
//        $redis->connect('')
    }
}