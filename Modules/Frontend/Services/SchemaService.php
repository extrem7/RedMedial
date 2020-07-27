<?php

namespace Modules\Frontend\Services;

use App\Models\Article;
use App\Models\Rss\Post;
use Spatie\SchemaOrg\Schema;

class SchemaService
{
    /* @return \Spatie\SchemaOrg\Article
     * @var $article Article|Post
     */
    public function article($article)
    {
        return Schema::article()
            ->headline($article->title)
            ->image($article->image)
            ->url($article->link)
            ->articleBody($article->body)
            ->datePublished($article->created_at)
            ->dateModified($article->updated_at ?? $article->created_at)
            ->author(Schema::person()->name('RedMedial'))
            ->publisher(Schema::organization()
                ->name('RedMedial')
                ->logo(Schema::imageObject()->url(url(asset('/dist/img/logo.png')))));
    }
}
