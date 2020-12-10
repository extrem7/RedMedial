<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\HealthStatus;
use Notification;
use PragmaRX\Health\Support\Resource;

class RedHealth extends Command
{
    protected $signature = 'red:health';

    protected $description = 'Check RedMedial health and sent notifications';

    public function handle(): void
    {
        $generalHealthState = app('pragmarx.health')->getResources();

        $generalHealthState->each(function ($resource) {
            if (!$resource->isHealthy()) {
                Notification::route('telegram', config('redmedial.telegram_channel_id'))
                    ->notify(new HealthStatus($resource));
            }
        });

    }
}
