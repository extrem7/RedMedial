<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Notifications\HealthStatus;
use Log;
use Notification;
use PragmaRX\Health\Support\Resource;

class RedHealth extends Command
{
    protected $signature = 'red:health';

    protected $description = 'Check RedMedial health and sent notifications';

    public function handle(): void
    {
        if (config('app.debug')) {
            return;
        }

        try {
            $generalHealthState = app('pragmarx.health')->getResources();

            $generalHealthState->each(function (Resource $resource) {
                $resource->check();
                if (!$resource->isHealthy()) {
                    Notification::route('telegram', config('redmedial.telegram_channel_id'))
                        ->notify(new HealthStatus($resource));
                }
            });
        } catch (Exception $e) {
            Log::error('Site health check failed');
        }
    }
}
