<?php

namespace App\Repositories\Interfaces;


use App\Models\Rss\Channel;
use Modules\Frontend\Http\Resources\ArticleCollection;

interface PostRepositoryInterface
{
    public function getCovid(): array;

    public function getByChannel(Channel $channel): ArticleCollection;

    public function search(string $query): ArticleCollection;
}
