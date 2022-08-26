<?php

namespace YG\Phalcon\Sms;

use YG\Phalcon\Sms\Models\SendSmsResponse;

class MockClient implements ClientInterface
{
    public function __construct(array $options, array $defaultParams = [])
    {
    }

    public function send(string $message, array $phones, array $params = []): SendSmsResponse
    {
        return new SendSmsResponse(rand(100000, 999999), '', true);
    }

    public function sendMultiple(array $phonesAndMessages, array $params = []): SendSmsResponse
    {
        return new SendSmsResponse(rand(100000, 999999), '', true);
    }
}