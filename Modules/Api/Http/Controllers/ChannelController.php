<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Rss\Channel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
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

        $channels = Channel::ordered()
            ->whereIn('id', setting('international_medias'))
            ->with(['logoMedia', 'posts' => function (Relation $posts) use ($params) {
                $posts->select(['channel_id', 'id', 'title', 'created_at'])->limit($params['posts_limit'] ?? 6);
            }])
            ->get(['id', 'name']);

        return ChannelResource::collection($channels);
    }

    /**
     * @api {post} /channels/suggest Suggest a feed
     * @apiName SuggestChannel
     * @apiGroup Channels
     * todo user check
     * @apiParam {String} url Link to rss feed.
     */
    public function suggest(Request $request)
    {
        $this->validate($request, [
            'url' => ['required', 'url']
        ]);

        Mail::raw("New rss channel suggestion: {$request->get('url')}", function ($message) {
            $message->from('us@example.com', 'Laravel');

            $message->to('extrem7ipad@gmail.com');
        });

        return response()->json([
            'message' => 'Url has been suggested'
        ]);
    }
}
