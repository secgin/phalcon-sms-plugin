<?php

namespace YG\Phalcon\Sms;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class ClientProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $config = $di->getShared('config')->get('sms')->toArray();

        $di->setShared('sms', function() use ($config) {
            return new Client($config);
        });
    }
}