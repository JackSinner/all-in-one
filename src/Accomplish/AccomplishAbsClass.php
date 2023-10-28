<?php

namespace Library\Europe\Accomplish;

use Library\Europe\Exception\HttpRequestException;
use Library\Europe\Platform\Platform;


abstract class AccomplishAbsClass
{


    protected static ?object $instance = null;

    protected Platform $platform;

    protected BaseConfig $config;

    protected function __construct()
    {

    }

    private function __clone()
    {

    }

    final public static function instance(): object
    {
        if (!self::$instance) {
            self::$instance = new static();
            self::$instance->platform = new Platform();
        }
        return self::$instance;
    }

    final public function setConfig(BaseConfig $config): self
    {
        $this->config = $config;
        return $this;
    }


    /**
     * @throws HttpRequestException
     */
    final protected function post(string $url, array $data = [], array $headers = [])
    {
        try {
            //判断提交方式,默认json方式提交
            $isJson = array_filter($headers, fn($value) => str_replace(' ', '', $value) == 'Content-Type:application/json');
            if ($isJson) {
                //json方式提交
                $body = json_encode($data);
            } else {
                //表单方式提交
                $body = http_build_query($data);
            }
            $c = curl_init();
            curl_setopt_array($c, array(
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_RETURNTRANSFER => true,
            ));
            $res = curl_exec($c);
            if ($res === false) {
                if (curl_errno($c) != 0) {
                    throw new \Exception(curl_error($c));
                }
            }
            return json_decode($res, true);
        } catch (\Exception $exception) {
            throw new HttpRequestException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        } finally {
            isset($c) && curl_close($c);
        }
    }

    final protected function buildJsonHeader(): array
    {
        return array(
            'Content-Type:application/json',
        );
    }

    final protected function buildXWWWFormUrlEncodeHeader(): array
    {
        return array(
            'Content-Type:application/x-www-form-urlencoded',
        );
    }

    final protected function get(string $url, array $data = [], array $headers = [])
    {
        try {
            if ($data) {
                $query = http_build_query($data);
                $url = sprintf("%s?%s", $url, $query);
            }
            $c = curl_init();
            curl_setopt_array($c, array(
                CURLOPT_URL => $url,
                CURLOPT_POST => false,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_RETURNTRANSFER => true,
            ));
            $res = curl_exec($c);
            if ($res === false) {
                if (curl_errno($c) != 0) {
                    throw new \Exception(curl_error($c));
                }
            }
            return json_decode($res, true);
        } catch (\Exception $exception) {
            throw new HttpRequestException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        } finally {
            isset($c) && curl_close($c);
        }
    }

    /**
     * 循环组合url查询参数
     * @param array $data
     * @return false|string
     */
    final public function eachBuildQuery(array $data)
    {
        $query = '';
        foreach ($data as $key => $value) {
            $query .= "{$key}={$value}&";
        }
        return substr($query, 0, -1);
    }
}