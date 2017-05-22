<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AboutAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application about account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('about_account.index');
    }
}
