<?php

namespace App\Http\Controllers;

class ResearchController extends Controller
{
    public function about()
    {
        return view('research.about');
    }

    public function team()
    {
        return view('research.team');
    }
}
