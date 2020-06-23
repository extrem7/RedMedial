<?php

use App\Models\Article;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Red Medial', route('frontend.home'));
});

Breadcrumbs::for('404', function ($trail) {
    $trail->parent('home');
    $trail->push('404');
});

Breadcrumbs::for('articles', function ($trail) {
    $trail->parent('home');
    $trail->push('Blog', route('frontend.articles.index'));
});

Breadcrumbs::for('articles.show', function ($trail, Article $article) {
    $trail->parent('articles');
    $trail->push($article->title);
});


