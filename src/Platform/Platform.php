<?php

namespace Library\Europe\Platform;

use think\App;

class Platform
{
    //当前环境,默认php原生
    private int $platform = 0;

    //thinkphp环境
    const ENV_THINKPHP_PLATFORM = 1;

    //配置文件名称
    const CONFIG_NAME = 'fusion_cloud.php';


    //配置文件
    protected array $config = [
        'user_name' => '',
        'password' => '',
        'sign' => '',
        'tpl_id' => '',
    ];

    public function __construct()
    {
        //判断是什么环境
        if (class_exists(App::class)) {
            //thinkphp
            $this->platform = self::ENV_THINKPHP_PLATFORM;
        }//。。。还有更多环境
        //配置文件
        $this->parseConfig();
    }

    /**
     * 返回当前的平台
     * @return int
     */
    public function getPlatform(): int
    {
        return $this->platform;
    }

    /**
     * @throws \Exception
     */
    private function parseConfig()
    {
        if ($this->platform == self::ENV_THINKPHP_PLATFORM) {
            //thinkphp环境
            $configPath = APP_PATH . 'extra/';
        } else {
            //没有第三方框架
            $configPath = __DIR__ . '/';
        }
        $configFile = sprintf("%s%s", $configPath, self::CONFIG_NAME);
        $config = [];
        if (!file_exists($configFile)) {
            //配置文件不存在,自动导出文件
            file_put_contents($configFile, "<?php \nreturn " . var_export($this->config, true) . ';');
            throw new \Exception(sprintf("配置文件未配置,已将配置文件复制到%s目录,请先配置", $configFile));
        }
        $config = require $configFile;
        $this->config = array_merge($this->config, $config);
    }

    public function getConfig($name)
    {
        if (isset($this->config[$name])) {
            return $this->config[$name];
        }
        return null;
    }
}