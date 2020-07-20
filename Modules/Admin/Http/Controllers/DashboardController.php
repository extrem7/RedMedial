<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Article;
use App\Models\Rss\Channel;
use App\Models\Rss\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('Dashboard');

        $posts = Post::count();
        $channels = Channel::count();
        $articles = Article::count();
        $users = User::count();

        return view('admin::dashboard', compact('posts', 'channels', 'articles', 'users'));
    }
}
