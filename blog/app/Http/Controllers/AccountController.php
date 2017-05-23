<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('account.index');
    }

    public function getSettings() {
        return view('account.settings');
    }
}
