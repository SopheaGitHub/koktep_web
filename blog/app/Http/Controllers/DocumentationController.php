<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DocumentationController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->data->web_title = 'Contact Us';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $request = \Request::all();
        // add system log
        $this->systemLogs('view', 'documentation', $request);
        // End
        return view('documentation.index', ['data'=>$this->data]);
    }
}
