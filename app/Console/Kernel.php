<?php

namespace App\Console;

use App\Console\Commands\RedHealth;
use App\Services\SocialService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RedHealth::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('red:health')
            ->hourly()
            ->timezone('Europe/Kiev')
            ->between('8:00', '22:00');

        $schedule->call(function () {
            $socialService = new SocialService();
            $socialService->update();
        })->daily();

        $schedule->command('telescope:prune --hours=48')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
