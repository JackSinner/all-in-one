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
        if (!$this->exists($key)) {
            return $default;
        }
        //存在该key,返回
    }

    public function exists(string $key): bool
    {
        $path = $this->getCacheFilePath($key);
        if (!file_exists($path)) {
            return false;
        }
        //读取文件
        $content = $this->getFileContent($path);
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

    private function getFileContent(string $filePath): string
    {
        $data = "";
        try {
            $f = fopen($filePath, 'r+');
            while (!feof($f)) {
                $data .= fgets($f);
            }
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            (isset($f) && is_resource($f)) && fclose($f);
        }
        return $data;
    }
}