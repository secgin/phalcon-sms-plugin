<?php

namespace YG\Phalcon\Sms\Models;

class SendSmsResponse
{
    public string $messageId;

    public string $message;

    public bool $isSuccess;

    public function __construct(string $messageId, string $message, bool $isSuccess)
    {
        $this->messageId = $messageId;
        $this->message = $message;
        $this->isSuccess = $isSuccess;
    }
}