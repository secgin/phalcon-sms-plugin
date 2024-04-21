<?php

namespace YG\Phalcon\Sms;

use YG\Netgsm\Soap\Client as SoapClient;
use YG\Phalcon\Sms\Models\SendSmsResponse;

class NetgsmClient implements ClientInterface
{
    private SoapClient $sopClient;

    public function __construct(array $options)
    {
        $username = $options['username'] ?? '';
        $password = $options['password'] ?? '';
        $header = $options['header'] ?? '';

        unset($options['username'], $options['password'], $options['header']);

        $this->sopClient = new SoapClient(
            $username,
            $password,
            $header,
            $options);
    }

    public function send(string $message, array $phones, array $params = []): SendSmsResponse
    {
        $response = $this->sopClient->send($message, $phones, $params);

        return new SendSmsResponse($response->messageId, $response->errorMessage, $response->isSuccess());
    }

    public function sendMultiple(array $phonesAndMessages, array $params = []): SendSmsResponse
    {
        $response = $this->sopClient->sendMultiple($phonesAndMessages, $params);

        return new SendSmsResponse($response->messageId, $response->errorMessage, $response->isSuccess());
    }
}