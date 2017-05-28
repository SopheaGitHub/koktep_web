<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->data->web_title = 'Home';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = \Request::all();

        $this->data->action_list = url('/post-account/list');
        return view('home', ['data'=>$this->data]);
    }
}
