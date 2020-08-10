<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Page;
use App\Models\Rss\Channel;
use App\Models\Rss\Country;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Api\Http\Resources\ChannelResource;

/**
 * @group Pages
 */
class PageController extends Controller
{
    /**
     * @api {get} /pages/red-de-medios RedDeMedios page
     * @apiName GetRedDeMediosPage
     * @apiGroup Pages
     *
     * @apiSuccess {String} title Page title.
     * @apiSuccess {String} body Page body.
     * @apiSuccess {Object[]} tabs Page tabs.
     * @apiSuccess {String} tabs.title Tab title.
     * @apiSuccess {Object[]} tabs.channels Tab channels.
     * @apiSuccess {Number} tabs.channels.id Channel id.
     * @apiSuccess {String} tabs.channels.name Channel name.
     * @apiSuccess {String} tabs.channels.logo Channel image.
     *
     */
    public function redDeMedios(ChannelRepositoryInterface $channelRepository)
    {
        $page = Page::whereSlug('red-de-medios')->orWhere('id', 4)->firstOrFail();

        $internationalChannels = Channel::with('logoMedia')
            ->whereIn('id', setting('international_medias'))
            ->get(['id', 'slug', 'name']);

        $chile = Country::whereSlug('chile')->orWhere('id', 11)->with(['channels' => function (Relation $channels) {
            $channels->with('logoMedia')->select(['id', 'country_id', 'slug', 'name', 'link']);
        }])->first();

        return [
            'title' => $page->title,
            'body' => $page->body,
            'tabs' => [
                [
                    'title' => 'Red de medios-international',
                    'channels' => ChannelResource::collection($internationalChannels)
                ],
                [
                    'title' => 'Red de medios-Chile',
                    'channels' => ChannelResource::collection($chile->channels)
                ]
            ]
        ];
    }
}
