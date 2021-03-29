<?php

namespace Modules\Frontend\Http\Controllers\Account;

use App\Models\Rss\Category;
use App\Models\Rss\Country;
use App\Models\Rss\Language;
use Inertia\Response;
use Modules\Frontend\Http\Controllers\Controller;

class IframeController extends Controller
{
    public function __invoke(): Response
    {
        $this->seo()->setTitle('Customized news iframe');

        $languages = Language::ordered()->get(['name as text', 'slug as value'])->toArray();
        $countries = Country::ordered()->get(['name as text', 'slug as value'])->toArray();
        $topics = Category::all(['name as text', 'slug as value'])->toArray();

        foreach (['languages', 'countries', 'topics'] as $array) {
            array_unshift($$array, ['text' => '', 'value' => null]);
        }

        return inertia('IframeGenerator', compact('languages', 'countries', 'topics'));
    }
}
