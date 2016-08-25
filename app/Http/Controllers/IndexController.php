<?php

namespace LaraCall\Http\Controllers;

use Illuminate\Http\Request;

use LaraCall\Http\Requests;

class IndexController extends Controller
{
    public function index()
    {
        return view('pages.buy_credit');
    }
}
