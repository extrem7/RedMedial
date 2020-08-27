<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Rss\Channel;
use App\Models\Rss\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Collection;
use Mail;
use Modules\Api\Http\Resources\ChannelResource;

/**
 * @group  Channels
 */
class ChannelController extends Controller
{
    /**
     * @api {get} /channels List of channels
     * @apiName GetChannels
     * @apiGroup Channels
     *
     * @apiParam {Number} [limit] Number of channels to load.
     * @apiParam {Number} [country] Channel country id.
     *
     * @apiSuccess {Number} id Channel id.
     * @apiSuccess {String} name Channel name.
     * @apiSuccess {String} logo Channel image.
     */
    public function index(Request $request)
    {
        $params = $this->validate($request, [
            'limit' => ['nullable', 'numeric', 'min:1'],
            'country_id' => ['nullable', 'numeric', 'exists:rss_countries,id']
        ]);

        $channels = Channel::ordered()
            ->when(isset($params['limit']), fn(Builder $q) => $q->limit($params['limit']))
            ->when(isset($params['country_id']), fn(Builder $q) => $q->where('country_id', $params['country_id']))
            ->with('logoMedia')
            ->get(['id', 'name']);

        return ChannelResource::collection($channels);
    }

    /**
     * @api {get} /channels/international List of international channels
     * @apiName GetInternationalChannels
     * @apiGroup Channels
     *
     * @apiParam {Number} [posts_limit] Number of posts to load for each channel.
     *
     * @apiSuccess {Number} id Channel id.
     * @apiSuccess {String} name Channel name.
     * @apiSuccess {String} logo Channel image.
     *
     * @apiSuccess {Object[]} posts Posts from channel.
     * @apiSuccess {Number} posts.id Post id.
     * @apiSuccess {String} posts.title Post title.
     * @apiSuccess {String} posts.date Post date.
     * @apiSuccess {String} posts.thumbnail Post image.
     */
    public function international(Request $request)
    {
        $params = $this->validate($request, [
            'posts_limit' => ['nullable', 'numeric', 'min:1'],
        ]);

        /* @var $user User */
        $user = $request->user();

        $favorite = $user->favorite->pluck('channel_id');

        $countryChannels = [];
        if ($user->information->country !== null) {
            $countryChannels = Channel::ordered()
                ->where('country_id', $user->information->country->id)
                ->select('id')
                ->pluck('id');
        }

        $international = setting('international_medias');

        $channels = Channel::query()
            ->whereIn('id', [...$favorite, ...$countryChannels, ...$international])
            ->with(['logoMedia', 'country', 'posts' => function (Relation $posts) use ($params) {
                $posts->select(['channel_id', 'id', 'title', 'created_at'])->limit($params['posts_limit'] ?? 6);
            }])
            ->get(['id', 'country_id', 'name']);

        $channels->transform(function (Channel $channel) {
            $channel->posts->transform(function (Post $post) use ($channel) {
                if ($channel->country) $post->setRelation('country', $channel->country);
                return $post;
            });
            return $channel;
        });

        $channels = $channels->sort(function (Channel $a, Channel $b) use ($favorite, $countryChannels, $international) {
            if (!empty($international)) {
                if (in_array($a->id, $international) && !in_array($b->id, $international)) return 1;
                if (!in_array($a->id, $international) && in_array($b->id, $international)) return -1;
            }
            if ($favorite->isNotEmpty()) {
                if ($favorite->contains($a->id) && !$favorite->contains($b->id)) return -1;
                if (!$favorite->contains($a->id) && $favorite->contains($b->id)) return 1;
            }
            if ($countryChannels->isNotEmpty()) {
                if ($countryChannels->contains($a->id) && !$countryChannels->contains($b->id)) return -1;
                if (!$countryChannels->contains($a->id) && $countryChannels->contains($b->id)) return 1;
            }
            return $a->id > $b->id ? 1 : -1;
        });

        return ChannelResource::collection($channels);
    }

    /**
     * @api {post} /channels/suggest Suggest a feed
     * @apiName SuggestChannel
     * @apiGroup Channels
     * @apiParam {String} url Link to rss feed.
     */
    public function suggest(Request $request)
    {
        $this->validate($request, [
            'url' => ['required', 'url']
        ]);

        $user = $request->user();

        Mail::raw("New rss channel suggestion from $user->email : {$request->get('url')}", function (Message $message) {
            $message->subject('[RedMedial] new rss feed suggestion');

            $message->to('extrem7ipad@gmail.com');
        });

        return response()->json([
            'message' => 'Url has been suggested'
        ]);
    }
}
