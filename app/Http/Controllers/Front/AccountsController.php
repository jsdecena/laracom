<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class AccountsController extends Controller
{
    public function index()
    {
        return view('front.accounts');
    }
}