<?php

namespace Database\Seeders;

use App\Models\Rss\Channel;
use Illuminate\Database\Seeder;

class RssChannelsSeeder extends Seeder
{
    public function run(): void
    {
        $channels = require(database_path('old/channels.php'));
        $countriesMapping = require(database_path('old/countriesMapping.php'));

        $this->command->getOutput()->progressStart(count($channels));

        \DB::transaction(function () use ($channels, $countriesMapping) {
            $i = 1;
            foreach ($channels as $item) {
                $data = [
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'source' => $item['link'],
                    'feed' => $item['feed'],
                    'description' => $item['description'],
                    'use_fulltext' => $item['use_fulltext'],
                    'use_og' => $item['use_og'],
                    'is_active' => true,
                    'order_column' => $i
                ];
                $i++;

                if (isset($item['country_id'], $countriesMapping[$item['country_id']])) {
                    $data['country_id'] = $countriesMapping[$item['country_id']];
                }

                $channel = Channel::create($data);

                if ($files = glob(resource_path('old/channels/' . $item['id'] . '.*'))) {
                    $channel->addMedia($files[0])->preservingOriginal()->toMediaCollection('logo');
                }

                $this->command->getOutput()->progressAdvance();
            }
        });

        $this->command->getOutput()->progressFinish();
    }
}
