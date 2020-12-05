<?php

namespace App\Repositories\Interfaces;

use App\Models\Rss\Category;
use App\Models\Rss\Channel;
use Modules\Frontend\Http\Resources\ArticleCollection;

interface PostRepositoryInterface
{
    public function getHot(): array;

    public function getCovid(): array;

    public function getByChannel(Channel $channel): ArticleCollection;

    public function getByCategory(Category $category): ArticleCollection;

    public function search(string $query): ArticleCollection;
}
