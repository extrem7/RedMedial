<?php

use App\Models\Rss\Channel;
use App\Models\Rss\Country;
use Illuminate\Database\Seeder;

class RssChannelsSeeder extends Seeder
{
    public function run()
    {
        $channels = [
            [
                'name' => 'Sputnik',
                'feed' => 'https://mundo.sputniknews.com/export/rss2/archive/index.xml'
            ],
            [
                'name' => 'RT',
                'feed' => 'https://actualidad.rt.com/feeds/all.rss'
            ],
            [
                'name' => 'La Iguana',
                'feed' => 'https://www.laiguana.tv/feed/'
            ],
            [
                'name' => 'Корреспондент',
                'feed' => 'http://k.img.com.ua/rss/ru/all_news2.0.xml'
            ],
            [
                'name' => 'Aporrea',
                'feed' => 'https://feeds.feedburner.com/aporrea'
            ],
            [
                'name' => 'La Verdad',
                'feed' => 'https://laverdadonline.com/feed/'
            ],
            [
                'name' => 'Middle east monitor',
                'feed' => 'https://www.middleeastmonitor.com/feed/'
            ]
        ];
        /* @var $chile Country */
        $chile = Country::where('slug', 'chile')->first();
        foreach ($channels as $channel) {
            $channel['is_active'] = true;
            $channel = $chile->channels()->create($channel);
            /* @var $channel Channel */
            $channel->addMediaFromUrl('https://picsum.photos/260/48')->toMediaCollection('logo');
        }
    }
}
