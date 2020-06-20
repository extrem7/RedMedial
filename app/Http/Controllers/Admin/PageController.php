<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $this->meta->prependTitle('Pages');

        $pages = Page::all(['id', 'title', 'slug', 'created_at', 'updated_at']);

        share(compact('pages'));

        return view('pages.index');
    }

    public function create()
    {
        $this->meta->prependTitle('Create a new page');

        return view('pages.create');
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
        $this->meta->prependTitle('Edit a page');

        share(compact('page'));

        return view('pages.edit');
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
