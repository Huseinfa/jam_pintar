<?php

namespace App\Http\Controllers;

use Illuminate\View\View;


class DashboardController extends Controller
{
    public function index()
    {
        // menambahkan logic agar admin masuk ke backoffice 
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('backoffice.index');
        }
        return view('pages.dashboard');
    }
}