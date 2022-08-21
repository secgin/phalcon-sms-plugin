<?php

namespace YG\Phalcon\Sms;

use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;
use YG\Phalcon\Sms\Models\SendSmsResponse;

class Client implements ClientInterface, EventsAwareInterface
{
    private ClientInterface $client;

    private ?ManagerInterface $eventsManager = null;

    public function __construct(array $options, array $defaultParams = [])
    {
        $clientClass = $options['provider'] ?? null;
        unset($options['provider']);

        switch ($clientClass)
        {
            case 'netgsm':
                $this->client = new NetgsmClient($options, $defaultParams);
                break;
            default:
                throw new \InvalidArgumentException('Invalid client class');
        }
    }

    public function send(string $message, array $phones, array $params = []): SendSmsResponse
    {
        $response = $this->client->send($message, $phones, $params);

        if ($response->isSuccess)
            $this->eventsManager->fire('sms:afterSend', $response);
        else
            $this->eventsManager->fire('sms:afterSendError', $response);

        return $response;
    }

    public function sendMultiple(array $phonesAndMessages, array $params = []): SendSmsResponse
    {
        $response = $this->sendMultiple($phonesAndMessages, $params);

        if ($response->isSuccess)
            $this->eventsManager->fire('sms:afterSend', $response);
        else
            $this->eventsManager->fire('sms:afterSendError', $response);

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