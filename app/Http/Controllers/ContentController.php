<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Recommendation;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::all();
        $recommendations = Recommendation::all();

        return view('pages.backoffice.Contents.index', compact('contents', 'recommendations'));
    }
}