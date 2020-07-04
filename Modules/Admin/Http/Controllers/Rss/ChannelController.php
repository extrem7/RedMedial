<?php

namespace Modules\Admin\Http\Controllers\Rss;

use App\Models\Rss\Channel;
use App\Services\ChannelsService;
use Illuminate\Http\Request;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\IndexRequest;
use Modules\Admin\Http\Requests\Rss\ChannelRequest;

class ChannelController extends Controller
{
    protected ChannelsService $channelsService;

    public function __construct()
    {
        $this->channelsService = app(ChannelsService::class);
    }

    public function index(IndexRequest $request)
    {
        $this->seo()->setTitle('Channels');

        $sort = $request->get('sortDesc') ?? true;

        $channels = Channel::query()->select(['id', 'country_id', 'name', 'is_active', 'last_run', 'created_at'])
            ->when($request->get('searchQuery'), fn($q) => $q->search($request->get('searchQuery')))
            ->orderBy($request->get('sortBy') ?? 'id', $sort ? 'desc' : 'asc')
            ->with(['country'])
            ->paginate(10);

        if (request()->expectsJson()) {
            return $channels;
        } else {
            share(compact('channels'));
        }

        return view('admin::rss.channels.index');
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new channel');

        $this->channelsService->shareForCRUD();

        return view('admin::rss.channels.form');
    }

    public function store(ChannelRequest $request)
    {
        $channel = new Channel($request->validated());

        if ($request->hasFile('logo'))
            $channel->uploadLogo($request->file('logo'));

        $channel->save();

        return response()->json([
            'status' => 'Channel has been created',
            'id' => $channel->id
        ], 201);
    }

    public function edit(Channel $channel)
    {
        $this->seo()->setTitle('Edit a channel');

        $this->channelsService->shareForCRUD();

        $channel->append('logo');
        share(compact('channel'));

        return view('admin::rss.channels.form');
    }

    public function update(ChannelRequest $request, Channel $channel)
    {
        $channel->update($request->validated());

        if ($request->hasFile('logo'))
            $channel->uploadLogo($request->file('logo'));

        $channel->load('logoMedia');
        $channel->append('logo');

        return response()->json([
            'status' => 'Channel has been updated',
            'channel' => $channel
        ]);
    }

    public function destroy(Channel $channel)
    {
        $channel->delete();
        return response()->json(['status' => 'Channel has been deleted']);
    }

    public function toggleActive(Request $request, Channel $channel)
    {
        $this->validate($request, [
            'is_active' => ['required', 'boolean']
        ]);

        $channel->is_active = $request->boolean('is_active');
        $channel->save();

        return response()->json([
            'status' => "'$channel->name' channel parsing has been " . ($channel->is_active ? 'activated' : 'deactivated')
        ]);
    }
}
