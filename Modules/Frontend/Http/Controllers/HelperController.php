<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Article;
use App\Models\Page;
use App\Models\Rss\Channel;
use App\Models\Rss\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class HelperController extends Controller
{
    public function sitemap(Request $request)
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
                ->setPriority(1)
            )->add(Url::create('/quienes-somos')
                ->setLastModificationDate(Page::whereSlug('quienes-somos')->first()->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.5)
            )->add(Url::create('/contacto')
                ->setLastModificationDate(Page::whereSlug('contacto')->first()->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.5)
            )->add(Url::create('/red-de-medios')
                ->setLastModificationDate(Page::whereSlug('red-de-medios')->first()->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.5)
            )->add(Url::create('/all-rss')
                ->setLastModificationDate(Page::whereSlug('all-rss')->first()->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
                ->setPriority(0.8)
            )->add(Url::create(route('frontend.articles.index'))
                ->setLastModificationDate(Article::latest()->first()->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.7)
            );

        Article::published()->get()->each(function (Article $article) use ($sitemap) {
            $sitemap->add(Url::create($article->link)
                ->setLastModificationDate($article->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_NEVER)
                ->setPriority(0.6));
        });

        Country::ordered()->get()->each(function (Country $country) use ($sitemap) {
            $sitemap->add(Url::create($country->link)
                ->setLastModificationDate($country->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.4));
        });
        Channel::ordered()->get()->each(function (Channel $channel) use ($sitemap) {
            $sitemap->add(Url::create(route('frontend.rss.channels.show', $channel->slug))
                ->setLastModificationDate($channel->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
                ->setPriority(0.4));
        });

        return $sitemap->toResponse($request);
    }
}
