<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('Dashboard');

        $articles = Article::count();
        $users = User::count();

        return view('admin.dashboard', compact('articles', 'users'));
    }
}
