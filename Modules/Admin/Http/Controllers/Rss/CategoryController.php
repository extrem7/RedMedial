<?php

namespace Modules\Admin\Http\Controllers\Rss;

use App\Models\Rss\Category;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\Rss\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('Categories');

        $categories = Category::query()->withCount('posts')->get();

        share(compact('categories'));

        return view('admin::rss.categories.index');
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new category');

        return view('admin::rss.categories.form');
    }

    public function store(CategoryRequest $request)
    {
        $category = new Category($request->validated());
        $category->save();

        return response()->json([
            'status' => 'Category has been created',
            'id' => $category->id
        ], 201);
    }

    public function edit(Category $category)
    {
        $this->seo()->setTitle('Edit a category');

        share(compact('category'));

        return view('admin::rss.categories.form');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json(['status' => 'Category has been updated']);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['status' => 'Category has been deleted']);
    }
}
