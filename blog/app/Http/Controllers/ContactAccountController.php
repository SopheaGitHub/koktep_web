<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ContactAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application contact account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('contact_account.index');
    }
}
