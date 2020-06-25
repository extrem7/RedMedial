<?php

namespace App\Http\Controllers\Frontend;

use App\Mail\ContactForm;
use App\Models\Page;
use App\Services\ArticlesService;
use Illuminate\Http\Request;
use Mail;
use Route2Class;

class PageController extends Controller
{
    public function home(ArticlesService $articlesService)
    {
        $page = Page::find(1);

        $this->seo()->setTitle($page->meta_title ?? $page->title, false);

        if ($description = $page->meta_description) {
            $this->seo()->setDescription($description);
        }

        $articles = $articlesService->getHome();

        return view('frontend.pages.home.page', compact('articles'));
    }

    public function search()
    {
        $this->seo()->setTitle('Search');

        return view('frontend.pages.search');
    }

    public function show(Page $page)
    {
        $this->seo()->setTitle($page->meta_title ?? $page->title);
        if ($description = $page->meta_description) {
            $this->seo()->setDescription($description);
        }

        $bodyClass = '';
        $view = 'default';

        if ($page->id === 2 || $page->slug === 'quienes-somos') {
            $bodyClass = 'about';
            $view = 'quienes-somos';
        } elseif ($page->id === 3 || $page->slug === 'contacto') {
            $bodyClass = 'contact';
            $view = 'contacto';
        } elseif ($page->id === 4 || $page->slug === 'red-de-medios') {
            $bodyClass = 'media-network';
            $view = 'red-de-medios';
        }

        Route2Class::addClass("page-template-$bodyClass");
        return view("frontend.pages.$view", compact('page'));
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

        Mail::to(get_admins_mails())->send(new ContactForm($data));

        return response()->json(['status' => 'Your message has been sent']);
    }
}
