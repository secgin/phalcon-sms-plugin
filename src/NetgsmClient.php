<?php

namespace YG\Phalcon\Sms;

use YG\ApiLibraryBase\Config;
use YG\Netgsm\Api\ApiClient;
use YG\Netgsm\Api\NetgsmApiClient;
use YG\Netgsm\Api\Sms\SendSms;
use YG\Phalcon\Sms\Models\SendSmsResponse;

class NetgsmClient implements ClientInterface
{
    private NetgsmApiClient $apiClient;

    public function __construct(array $options)
    {
        $config = Config::create([
            'serviceUrl' => 'https://api.netgsm.com.tr',
            'username' => $options['username'] ?? '',
            'password' => $options['password'] ?? '',
            'defaultMessageHeader' => $options['header'] ?? ''
        ]);
        $this->apiClient = new ApiClient($config);
    }

    public function send(string $message, array $phones, array $params = []): SendSmsResponse
    {
        $request = SendSms::create($phones[0], $message);

        if (count($phones) > 1)
        {
            for ($i=1; $i<count($phones); $i++)
                $request->add($phones[$i], $message);
        }

        $result = $this->apiClient->sendSms($request);

        return new SendSmsResponse($result->jobid, $result->description, $result->isSuccess());
    }

    public function sendMultiple(array $phonesAndMessages, array $params = []): SendSmsResponse
    {
        $firstPhone = array_key_first($phonesAndMessages);
        $firstMessage = $phonesAndMessages[$firstPhone];
        $request = SendSms::create($firstPhone, $firstMessage);

        unset($phonesAndMessages[$firstPhone]);
        foreach ($phonesAndMessages as $phone => $message)
            $request->add($phone, $message);

        $result = $this->apiClient->sendSms($request);

        return new SendSmsResponse($result->jobid, $result->description, $result->isSuccess());
    }
}