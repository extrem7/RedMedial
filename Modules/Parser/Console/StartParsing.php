<?php

namespace Modules\Parser\Console;

use Illuminate\Console\Command;
use Modules\Parser\Services\ParserService;

class StartParsing extends Command
{
    protected $signature = 'parser:start {--international} {--country=} {--channel=}';

    protected ParserService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new ParserService($this);
    }

    public function handle()
    {
        $this->info('Parsing started');

        $this->service->start();

        $this->info('Parsing done');
    }
}
