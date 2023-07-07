<?php

namespace Library\Europe\Accomplish;

use Library\Europe\Exception\HttpRequestException;
use Library\Europe\Interfaces\Sms\SmsInterface;
use Library\Europe\Platform\Platform;


abstract class AccomplishAbsClass
{


    protected static ?SmsInterface $instance = null;

    protected Platform $platform;

    protected function __construct()
    {

    }

    private function __clone()
    {

    }

    public static function instance(): SmsInterface
    {
        if (!self::$instance) {
            self::$instance = new static();
            self::$instance->platform = new Platform();
        }
        return self::$instance;
    }


    /**
     * @throws HttpRequestException
     */
    final protected function post(string $url, array $data = [], array $headers = [])
    {
        try {
            //判断提交方式,默认json方式提交
            $contentType = $headers['Content-Type'] ?? 'application/json';
            if ($contentType == 'application/json') {
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
}