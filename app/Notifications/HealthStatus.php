<?php

namespace App\Notifications;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use PragmaRX\Health\Support\Resource;

class HealthStatus extends Notification
{
    protected string $name;

    public function __construct(Resource $resource)
    {
        $this->name = $resource->name;
    }

    public function via(): array
    {
        return [TelegramChannel::class];
    }

    public function toTelegram(AnonymousNotifiable $channel): TelegramMessage
    {
        return TelegramMessage::create()
            ->to($channel->routeNotificationFor('telegram'))
            ->content("The \"{$this->name}\" service is in trouble and needs attention.");
    }
}
