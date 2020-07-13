<?php

namespace App\Repositories\Interfaces;


use App\Models\Rss\Channel;

interface PostRepositoryInterface
{
    public function getCovid(): array;

    public function getByChannel(Channel $channel, int $page = 1);

    public function cacheCovid(): void;
}
