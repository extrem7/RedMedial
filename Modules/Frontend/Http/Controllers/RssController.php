<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Rss\Channel;
use App\Models\Rss\Country;
use App\Models\Rss\Post;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\PlaylistRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Modules\Frontend\Services\SchemaService;

class RssController extends Controller
{
    protected ChannelRepositoryInterface $channelRepository;
    protected PostRepositoryInterface $postRepository;
    protected PlaylistRepositoryInterface $playlistRepository;

    public function __construct()
    {
        $this->channelRepository = app(ChannelRepositoryInterface::class);
        $this->postRepository = app(PostRepositoryInterface::class);
        $this->playlistRepository = app(PlaylistRepositoryInterface::class);
    }

    public function country(Country $country)
    {
        $this->seo()->setTitle($country->meta_title ?? $country->name);
        if ($description = $country->meta_description) $this->seo()->setDescription($description);

        $channels = $this->channelRepository->getByCountry($country);
        $playlists = $this->playlistRepository->getByCountry($country);

        share(compact('channels', 'playlists'));

        return view('frontend::rss.country', compact('country'));
    }

    public function channel(Channel $channel)
    {
        $this->seo()->setTitle($channel->meta_title ?? $channel->name);
        if ($description = $channel->meta_description) $this->seo()->setDescription($description);

        $posts = $this->postRepository->getByChannel($channel);
        abort_if($posts->collection->isEmpty(), 404);

        if (request()->expectsJson()) {
            return $posts;
        } else {
            share([
                'articles' => $posts,
                'channel' => $channel
            ]);
        }

        return view('frontend::rss.channel', compact('channel'));
    }

    public function show(Post $post, SchemaService $schemaService)
    {
        $post->load('imageMedia');
        $post->append(['image', 'link']);

        $this->seo()->setTitle($post->title);
        $this->seo()->setDescription(strip_tags($post->excerpt));
        if ($post->imageMedia) $this->seo()->addImages(url($post->getImage()));

        share([
            'article' => $post
        ]);

        $postSchema = $schemaService->article($post);

        return view('frontend::rss.post', compact('post', 'postSchema'));
    }
}
