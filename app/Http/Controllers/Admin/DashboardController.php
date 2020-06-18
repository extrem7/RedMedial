<?php

namespace App\Http\Controllers\Admin;

class DashboardController extends Controller
{
    public function index()
    {
        $this->meta->prependTitle('Dashboard');

        return view('dashboard');
    }
}
