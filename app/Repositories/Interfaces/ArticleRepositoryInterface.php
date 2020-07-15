<?php

namespace App\Repositories\Interfaces;

use Modules\Frontend\Http\Resources\ArticleCollection;
use Illuminate\Support\Collection;

interface ArticleRepositoryInterface
{
    public function getIndex(int $page = 1): ArticleCollection;

    public function getHome(): array;

    public function getSidebar(): ArticleCollection;

    public function get404(): Collection;

    public function shareForCRUD(): void;
}
