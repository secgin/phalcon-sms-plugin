<?php

namespace YG\Phalcon\Sms;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class ClientProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $smsConfig = $di->getShared('config')->get('sms')->toArray();

        $di->setShared('sms', function () use ($smsConfig) {
            $options = [
                'username' => $smsConfig['username'],
                'password' => $smsConfig['password'],
                'defaultMessageHeader' => $smsConfig['defaultMessageHeader'],
                'provider' => $smsConfig['provider']
            ];

            unset($smsConfig['username'], $smsConfig['password'], $smsConfig['defaultMessageHeader'],
                $smsConfig['provider']);

            return new Client($options, $smsConfig);
        });
    }
}