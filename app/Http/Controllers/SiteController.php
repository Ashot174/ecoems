<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    //
    protected $vars = array();
    protected $template;

    protected function renderOutput(){
        return view($this->template)->with($this->vars);
    }
}
