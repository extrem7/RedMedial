<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Rss\Channel;
use QCod\AppSettings\SavesSettings;
use QCod\AppSettings\Setting\AppSettings;

class AppSettingController extends Controller
{
    use SavesSettings {
        index as parentIndex;
    }

    public function index(AppSettings $appSettings)
    {
        $this->seo()->setTitle('Settings');

        $selectedChannels = explode(',', setting('international_medias'));
        $channels = Channel::get(['id', 'name'])->map(function (Channel $channel) use ($selectedChannels) {
            return [
                'id' => $channel->id,
                'text' => $channel->name,
                'selected' => in_array($channel->id, $selectedChannels)
            ];
        });
        share(compact('channels'));

        return $this->parentIndex($appSettings);
    }
}
