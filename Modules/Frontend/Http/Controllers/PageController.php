<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Page;
use App\Models\Rss\Country;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\PlaylistRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mail;
use Modules\Frontend\Http\Requests\ContactFormRequest;
use Modules\Frontend\Mail\ContactForm;

class PageController extends Controller
{
    protected ArticleRepositoryInterface $articleRepository;
    protected CountryRepositoryInterface $countryRepository;
    protected ChannelRepositoryInterface $channelRepository;
    protected PostRepositoryInterface $postRepository;
    protected PlaylistRepositoryInterface $playlistRepository;

    public function __construct()
    {
        $this->articleRepository = app(ArticleRepositoryInterface::class);
        $this->countryRepository = app(CountryRepositoryInterface::class);
        $this->channelRepository = app(ChannelRepositoryInterface::class);
        $this->postRepository = app(PostRepositoryInterface::class);
        $this->playlistRepository = app(PlaylistRepositoryInterface::class);
    }

    public function home(Request $request)
    {
        $page = Page::find(1);

        $this->seo()->setTitle($page->meta_title ?? $page->title, false);

        if ($description = $page->meta_description) {
            $this->seo()->setDescription($description);
        }

        $articles = $this->articleRepository->getHome();
        $hot = $this->postRepository->getHot();

        $country = $this->countryRepository->getByCode($request->get('country'));
        $internationalChannels = $this->channelRepository->getInternational();

        $playlists = $this->playlistRepository->getHome();

        share([
            'localChannels' => $country !== null ? $country->channels : null,
            'internationalChannels' => $internationalChannels,
            'playlists' => $playlists
        ]);

        return view('frontend::pages.home.page', compact('articles', 'hot', 'country'));
    }

    public function allRss(Page $page)
    {
        $channels = $this->channelRepository->paginate();

        if (request()->expectsJson()) {
            return $channels;
        }

        share(compact('channels'));

        return view('frontend::rss.index', compact('page'), ['orderName' => 'all-rss']);
    }

    public function allYoutube(Page $page)
    {
        $playlists = $this->playlistRepository->all();
        share(compact('playlists'));

        return view('frontend::pages.all-youtube', compact('page'));
    }

    public function redDeMedios(Page $page)
    {
        $international = $this->channelRepository->getInternational();
        $chile = $this->channelRepository->getByCountry(
            Country::whereSlug('chile')->orWhereIn('id', [11])->first()
        );

        return view("frontend::pages.red-de-medios", compact('page', 'international', 'chile'));
    }

    public function show(Page $pageModel)
    {
        $page = $pageModel;

        $this->seo()->setTitle($page->meta_title ?? $page->title);
        if ($description = $page->meta_description) {
            $this->seo()->setDescription($description);
        }

        $view = 'default';

        if ($page->id === 2 || $page->slug === 'quienes-somos') {
            $view = 'quienes-somos';
        } elseif ($page->id === 3 || $page->slug === 'contacto') {
            $view = 'contacto';
        } elseif ($page->id === 4 || $page->slug === 'red-de-medios') {
            return $this->redDeMedios($page);
        } elseif ($page->id === 10 || $page->slug === 'all-rss') {
            return $this->allRss($page);
        } elseif ($page->id === 11 || $page->slug === 'all-youtube') {
            return $this->allYoutube($page);
        }

        return view("frontend::pages.$view", compact('page'));
    }

    public function contactForm(ContactFormRequest $request): JsonResponse
    {
        Mail::to(get_admins_mails())->send(new ContactForm($request->validated()));

        return response()->json(['status' => 'Your message has been sent']);
    }
}
