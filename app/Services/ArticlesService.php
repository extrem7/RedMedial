<?php


namespace App\Services;


use App\Models\Article;

class ArticlesService
{
    public function shareForCRUD()
    {
        $statuses = collect(Article::$statuses)->map(fn($val, $key) => ['value' => $key, 'label' => $val])->values();

        share([
            'statuses' => $statuses
        ]);
    }
}
