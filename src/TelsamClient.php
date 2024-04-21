<?php

namespace YG\Phalcon\Sms;

use YG\Phalcon\Sms\Models\SendSmsResponse;
use YG\Telsam\Sms\ApiClient;
use YG\Telsam\Sms\Config;
use YG\Telsam\Sms\EndPoints\DynamicSms;
use YG\Telsam\Sms\EndPoints\MultiSms;
use YG\Telsam\Sms\EndPoints\SingleSms;

class TelsamClient implements ClientInterface
{
    private array $options;


    public function __construct(array $options)
    {
        if (empty($options['apiUrl']))
            $options['apiUrl'] = 'http://sms.telsam.com.tr:9587';

        $this->options = $options;
    }

    /**
     * @inheritDoc
     */
    public function send(string $message, array $phones, array $params = []): SendSmsResponse
    {
        $parameters = array_merge($this->options, $params);
        $apiClient = new ApiClient(Config::create($parameters));

        $result = count($phones) > 1
            ? $apiClient->sendMultiSms(MultiSms::create($phones, $message))
            : $apiClient->sendSingleSms(SingleSms::create($phones[0], $message));

        return new SendSmsResponse($result->getPkgId() ?? '', $result->getErrorMessage() ?? '', $result->isSuccess());
    }

    /**
     * @inheritDoc
     */
    public function sendMultiple(array $phonesAndMessages, array $params = []): SendSmsResponse
    {
        $parameters = array_merge($this->options, $params);
        $apiClient = new ApiClient(Config::create($parameters));

        $result = $apiClient->sendDynamicSms(DynamicSms::create($phonesAndMessages));

        return new SendSmsResponse($result->getPkgId() ?? '', $result->getErrorMessage() ?? '', $result->isSuccess());
    }
}