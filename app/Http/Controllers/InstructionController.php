<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstructionController extends Controller
{
    public function index()
    {
        // pastikan admin tidak boleh mengikui tes dan hanya student saja
        if(auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('backoffice.index');
        }
        return view('pages.student.instruction');
    }
}
