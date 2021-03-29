<?php

namespace Modules\Admin\Http\Controllers\Rss;

use App\Models\Rss\Language;
use Cacher;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\Rss\LanguageRequest;
use Modules\Admin\Http\Requests\Rss\SortRequest;

class LanguageController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('Languages');

        $languages = Language::ordered()->get();

        share(compact('languages'));

        return view('admin::rss.languages.index');
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new language');

        return view('admin::rss.languages.form');
    }

    public function store(LanguageRequest $request)
    {
        $language = new Language($request->validated());
        $language->save();

        return response()->json([
            'status' => 'Language has been created',
            'id' => $language->id
        ], 201);
    }

    public function edit(Language $language)
    {
        $this->seo()->setTitle('Edit a language');

        share(compact('language'));

        return view('admin::rss.languages.form');
    }

    public function update(LanguageRequest $request, Language $language)
    {
        $language->update($request->validated());

        return response()->json(['status' => 'Language has been updated', 'language' => $language]);
    }

    public function destroy(Language $language)
    {
        $language->delete();
        return response()->json(['status' => 'Language has been deleted']);
    }

    public function sort(SortRequest $request)
    {
        $order = $request->input('order');
        Language::setNewOrder($order);
        return response()->json(['status' => 'Languages has been sorted']);
    }
}
