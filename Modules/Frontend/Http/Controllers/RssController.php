<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Rss\Category;
use App\Models\Rss\Channel;
use App\Models\Rss\Country;
use App\Models\Rss\Post;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\PlaylistRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Frontend\Http\Resources\ArticleCollection;
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

    public function country(Country $country): View
    {
        $this->seo()->setTitle($country->meta_title ?? $country->name);
        if ($description = $country->meta_description) {
            $this->seo()->setDescription($description);
        }

        $channels = $this->channelRepository->getByCountry($country);
        $playlists = $this->playlistRepository->getByCountry($country);

        share(compact('channels', 'playlists'));

        return view('frontend::rss.country', compact('country'));
    }

    /* @return View|ArticleCollection */
    public function channel(Request $request, Channel $channel)
    {
        $this->seo()->setTitle($channel->meta_title ?? $channel->name);
        if ($description = $channel->meta_description) {
            $this->seo()->setDescription($description);
        }

        $posts = $this->postRepository->getByChannel($channel);
        abort_if($posts->collection->isEmpty(), 404);

        if ($request->has('api_life_hack') && $request->expectsJson()) {
            return $posts;
        }

        share([
            'articles' => $posts,
            'channel' => $channel
        ]);

        return view('frontend::rss.channel', compact('channel'));
    }

    public function category(Request $request, Category $category): View
    {
        $this->seo()->setTitle($category->meta_title ?? $category->name);
        if ($description = $category->meta_description) {
            $this->seo()->setDescription($description);
        }

        $posts = $this->postRepository->getByCategory($category);
        abort_if($posts->collection->isEmpty(), 404);

        if ($request->has('api_life_hack') && $request->expectsJson()) {
            return $posts;
        }

        share([
            'articles' => $posts,
            'category' => $category
        ]);

        return view('frontend::rss.channel', compact('category'));
    }

    public function show(Post $post, SchemaService $schemaService): View
    {
        $post->load('imageMedia');
        $post->append(['image', 'link']);

        $this->seo()->setTitle($post->title);
        $this->seo()->setDescription(strip_tags($post->excerpt));
        if ($post->imageMedia) {
            $this->seo()->addImages(url($post->getImage()));
        }

        share(['article' => $post]);

        $postSchema = $schemaService->article($post);

        return view('frontend::rss.post', compact('post', 'postSchema'));
    }
}
