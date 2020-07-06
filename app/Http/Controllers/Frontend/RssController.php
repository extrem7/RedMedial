<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Rss\Channel;
use App\Models\Rss\Country;
use App\Models\Rss\Post;
use App\Services\RssService;

class RssController extends Controller
{
    protected RssService $rssService;

    public function __construct()
    {
        $this->rssService = app(RssService::class);
    }

    public function country(Country $country)
    {
        $this->seo()->setTitle($country->meta_title ?? $country->name);
        if ($description = $country->meta_description) $this->seo()->setDescription($description);

        $channels = $this->rssService->getCountryChannels($country);

        share(compact('channels'));

        return view('frontend.rss.country', compact('country'));
    }

    public function channel(Channel $channel)
    {
        $this->seo()->setTitle($channel->meta_title ?? $channel->name);
        if ($description = $channel->meta_description) $this->seo()->setDescription($description);

        $posts = $this->rssService->getChannelPosts($channel);

        if (request()->expectsJson()) {
            return $posts;
        } else {
            share(['articles' => $posts]);
        }

        return view('frontend.rss.channel', compact('channel'));
    }

    public function show(Post $post)
    {
        $this->seo()->setTitle($post->title);

        return view('frontend.rss.post', compact('post'));
    }
}
