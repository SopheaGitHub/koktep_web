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
        // add system log
        $this->systemLogs('view', 'home', $request);
        // End
        $this->data->action_list = url('/post-account/list');
        if(\Session::has('love')) {
            return view('home', ['data'=>$this->data]);
        }else {
            return view('home_coming_soon', ['data'=>$this->data]);
        }
    }

    public function love($name) {
        \Session::put('love', $name);
        return redirect('/');
        exit();
    }

}
