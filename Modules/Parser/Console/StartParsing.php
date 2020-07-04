<?php

namespace Modules\Parser\Console;

use Illuminate\Console\Command;
use Modules\Parser\Services\ParserService;

class StartParsing extends Command
{
    protected $signature = 'parsing:start';

    public function handle()
    {
        $this->info('Parsing started');

        $service = new ParserService($this);
        $service->start();

        $this->info('Parsing done');
    }
}
