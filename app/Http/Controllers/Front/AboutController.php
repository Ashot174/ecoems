<?php

namespace App\Http\Controllers\Front;

use App\About;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        $about = About::first();
        if ($about) {
            return view('front.about', compact('about'));
        } else {
            return redirect()->back();
        }
    }
}
