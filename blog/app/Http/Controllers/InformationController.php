<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;

use App\Http\Requests;

class InformationController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');
        $this->data = new \stdClass();
        $this->information = new Information();
        $this->data->web_title = 'Information';
    }

    /**
     * Show the application account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetail()
    {
    	$request = \Request::all();
        // add system log
        $this->systemLogs('view', 'information', $request);
        // End

        return view('information.detail', ['data'=>$this->data]);
    }

}
