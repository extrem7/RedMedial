<?php

namespace App\Http\Controllers\Admin;

class DashboardController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('Dashboard');

        return view('admin.dashboard');
    }
}
