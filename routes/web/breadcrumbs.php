<?php

use App\Models\Article;
use App\Models\Page;
use App\Models\Rss\Channel;
use App\Models\Rss\Country;
use App\Models\Rss\Post;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Trail;

Breadcrumbs::for('home', function (Trail $trail) {
    $trail->push('Red Medial', route('frontend.home'));
});

Breadcrumbs::for('404', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('404');
});

Breadcrumbs::for('search', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Search');
});

Breadcrumbs::for('page', function (Trail $trail, Page $page) {
    $trail->parent('home');
    $trail->push($page->title);
});

Breadcrumbs::for('frontend.articles.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Blog', route('frontend.articles.index'));
});

Breadcrumbs::for('frontend.articles.index.page', function (Trail $trail, int $page = 1) {
    $trail->parent('frontend.articles.index');
    $trail->push("Page $page");
});

Breadcrumbs::for('frontend.articles.show', function (Trail $trail, Article $article) {
    $trail->parent('frontend.articles.index');
    $trail->push($article->title);
});

Breadcrumbs::for('frontend.rss.countries.show', function (Trail $trail, Country $country) {
    $trail->parent('home');
    $trail->push($country->name, route('frontend.rss.countries.show', $country->slug));
});

Breadcrumbs::for('frontend.rss.channels.show', function (Trail $trail, Channel $channel) {
    if ($country = $channel->country) {
        $trail->parent('frontend.rss.countries.show', $country);
    } else {
        $trail->parent('home');
    }
    $trail->push($channel->name, route('frontend.rss.channels.show', $channel->slug));
});

Breadcrumbs::for('frontend.rss.channels.show.page', function (Trail $trail, Channel $channel, int $page = 1) {
    $trail->parent('frontend.rss.channels.show', $channel);
    $trail->push("Page $page");
});

Breadcrumbs::for('frontend.rss.posts.show', function (Trail $trail, Post $post) {
    $trail->parent('frontend.rss.channels.show', $post->channel);
    $trail->push($post->title);
});

