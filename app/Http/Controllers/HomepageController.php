<?php

namespace Sprocketbox\DevGiving\Http\Controllers;

class HomepageController extends Controller
{
    public function index()
    {
        return view('homepage');
    }
}