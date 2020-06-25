<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Page;
use Modules\Admin\Http\Requests\PageRequest;

class PageController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('Pages');

        $pages = Page::all(['id', 'title', 'slug', 'created_at', 'updated_at']);

        $pages->transform(function ($page) {
            $page['link'] = route('frontend.pages.show', $page->slug);
            return $page;
        });

        share(compact('pages'));

        return view('admin::pages.index');
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new page');

        return view('admin::pages.form');
    }

    public function store(PageRequest $request)
    {
        $page = new Page($request->all());
        $page->save();

        return response()->json([
            'status' => 'Page has been created',
            'id' => $page->id
        ], 201);
    }

    public function edit(Page $page)
    {
        $this->seo()->setTitle('Edit a page');

        share(compact('page'));

        return view('admin::pages.form');
    }

    public function update(PageRequest $request, Page $page)
    {
        $page->update($request->all());

        return response()->json(['status' => 'Page has been updated']);
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return response()->json(['status' => 'Page has been deleted']);
    }
}
