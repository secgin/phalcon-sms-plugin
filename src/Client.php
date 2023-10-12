<?php

namespace YG\Phalcon\Sms;

use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;
use YG\Phalcon\Sms\Models\SendSmsResponse;

class Client implements ClientInterface, EventsAwareInterface
{
    private ClientInterface $client;

    private ?ManagerInterface $eventsManager = null;

    private array $providers = [
        'netgsm' => NetgsmClient::class,
        'telsam' => TelsamClient::class,
        'mock' => MockClient::class
    ];

    public function __construct(array $options, array $defaultParams = [])
    {
        $provider = $options['provider'] ?? null;
        unset($options['provider']);

        if (!$provider)
            throw new \InvalidArgumentException('Provider is required');

        $providerClass = $this->providers[$provider] ?? null;
        if (!$providerClass)
            throw new \InvalidArgumentException('Provider is not valid');

        $this->client = new $providerClass($options, $defaultParams);
    }

    public function send(string $message, array $phones, array $params = []): SendSmsResponse
    {
        $response = $this->client->send($message, $phones, $params);

        if ($this->eventsManager)
        {
            if ($response->isSuccess)
                $this->eventsManager->fire('sms:afterSend', $response);
            else
                $this->eventsManager->fire('sms:afterSendError', $response);
        }

        return $response;
    }

    public function sendMultiple(array $phonesAndMessages, array $params = []): SendSmsResponse
    {
        $response = $this->sendMultiple($phonesAndMessages, $params);

        if ($this->eventsManager)
        {
            if ($response->isSuccess)
                $this->eventsManager->fire('sms:afterSend', $response);
            else
                $this->eventsManager->fire('sms:afterSendError', $response);
        }

        return $response;
    }

    #region EventsAwareInterface
    public function getEventsManager(): ?ManagerInterface
    {
        return $this->eventsManager;
    }

    public function setEventsManager(ManagerInterface $eventsManager): void
    {
        $this->eventsManager = $eventsManager;
    }
    #endregion
}