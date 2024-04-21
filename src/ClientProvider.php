<?php

namespace YG\Phalcon\Sms;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class ClientProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $di->setShared('sms', function ()  {

            $config = $this->getShared('config');

            $smsConfig = $config->has('sms')
                ? $config->get('sms')->toArray()
                : [];

            return new Client($smsConfig);
        });
    }
}