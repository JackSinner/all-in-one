<?php

namespace Library\Europe\Library;

use Library\Europe\Platform\Platform;

/**
 * 正在实现,文件缓存
 */
class FileCache
{
    const FILE_CACHE_DIR = 'file_cache';

    const FILE_CACHE_KEY_PREFIX = 'europe';

    protected Platform $platform;

    public function __construct()
    {
        $this->platform = new Platform();
    }

    public function get(string $key, $default = null)
    {
        $key = $this->getKey($key);
        $path = $this->getCacheFilePath($key);
        if (!$path) {
            return "";
        }
        //存在该key,返回
        $data = $this->getFileContent($path);
        if ($data['ttl']) {

        }
    }

    /**
     * @param string $key
     * @param $value
     * @param int|null $ttl 秒
     * @return void
     */
    public function set(string $key, $value, ?int $ttl = null)
    {
        $key = $this->getKey($key);
        $path = $this->getCacheFilePath($key);
        try {
            if (!file_exists($path)) {
                @mkdir(str_replace(basename($path), "", $path), 0777, true);
            }
            $source = fopen($path, "w+");
            if ($source !== false) {
                flock($source, LOCK_EX);
            }
            //写入数据
            if (fwrite($source, $this->getWriteData($value, $ttl)) === false) {
                //写入失败
            }
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            if (isset($source) && is_resource($source)) {
                flock($source, LOCK_UN);
                fclose($source);
            }
        }
    }

    private function getWriteData($value, ?int $ttl = null): string
    {
        $now = time();
        if ($ttl) {
            $ttl += $now;
        }
        return json_encode(array(
            'data' => $value,
            'ttl' => $ttl,
        ));
    }

    public function exists(string $key): bool
    {
        $key = $this->getKey($key);
        $path = $this->getCacheFilePath($key);
        if (!file_exists($path)) {
            return false;
        }
        return false;
    }

    private function getCacheFilePath(string $key): ?string
    {
        $cacheDir = $this->getCacheDir();
        if ($cacheDir) {
            return sprintf("%s/%s", $cacheDir, $key);
        }
        return null;
    }

    /**
     * 获取缓存文件目录
     * @return string|null
     */
    private function getCacheDir(): ?string
    {
        switch ($this->platform->getPlatform()) {
            case Platform::ENV_THINKPHP_PLATFORM:
                return sprintf("%s%s", RUNTIME_PATH, self::FILE_CACHE_DIR);
        }
        return null;
    }


    private function getKey(string $key): string
    {
        return sprintf("%s_%s", self::FILE_CACHE_KEY_PREFIX, md5($key));
    }

    private function getFileContent(string $filePath): array
    {
        $data = "";
        try {
            $f = fopen($filePath, 'r');
            if ($f !== false) {
                flock($f, LOCK_EX);
                while (!feof($f)) {
                    $data .= fgets($f);
                }
            }
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            if ((isset($f) && is_resource($f))) {
                flock($f, LOCK_UN);
                fclose($f);
            }
        }
        if ($data) {
            $data = json_decode($data, true);
        }
        return $data;
    }
}