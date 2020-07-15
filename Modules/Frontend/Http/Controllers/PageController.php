<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Page;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;
use Modules\Frontend\Mail\ContactForm;

class PageController extends Controller
{
    protected ArticleRepositoryInterface $articleRepository;

    protected CountryRepositoryInterface $countryRepository;

    protected ChannelRepositoryInterface $channelRepository;

    protected PostRepositoryInterface $postRepository;

    public function __construct()
    {
        $this->articleRepository = app(ArticleRepositoryInterface::class);
        $this->countryRepository = app(CountryRepositoryInterface::class);
        $this->channelRepository = app(ChannelRepositoryInterface::class);
        $this->postRepository = app(PostRepositoryInterface::class);
    }

    public function home(Request $request)
    {
        $page = Page::find(1);

        $this->seo()->setTitle($page->meta_title ?? $page->title, false);

        if ($description = $page->meta_description) {
            $this->seo()->setDescription($description);
        }

        $articles = $this->articleRepository->getHome();
        $covid = $this->postRepository->getCovid();

        $country = $this->countryRepository->getByCode($request->get('country'));
        $internationalChannels = $this->channelRepository->getInternational();

        share([
            'localChannels' => $country !== null ? $country->channels : null,
            'internationalChannels' => $internationalChannels
        ]);

        return view('frontend::pages.home.page', compact('articles', 'covid', 'country'));
    }

    public function allRss(Page $page)
    {
        $channels = $this->channelRepository->paginate();

        if (request()->expectsJson()) {
            return $channels;
        } else {
            share(compact('channels'));
        }

        return view('frontend::rss.index', compact('page'), ['orderName' => 'all-rss']);
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
            $view = 'red-de-medios';
        } elseif ($page->slug == 'all-rss') {
            return $this->allRss($page);
        }

        // Route2Class::addClass("page-template-$bodyClass");
        return view("frontend::pages.$view", compact('page'));
    }

    public function contactForm(Request $request)
    {
        $data = $this->validate($request, [
            'name' => ['nullable', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'message' => ['nullable', 'string'],
        ]);

        \Mail::to(get_admins_mails())->send(new ContactForm($data));

        return response()->json(['status' => 'Your message has been sent']);
    }
}
