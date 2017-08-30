<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MessageController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->data->web_title = 'Message';
    }

    public function getIndex() {
    	$request = \Request::all();
        // add system log
        $this->systemLogs('view', 'message', $request);
        // End

        $this->data->action_list = url('/message/list');
        return view('message.index', ['data'=>$this->data]);
    }

    public function getList() {
    	return view('message.list', ['data'=>$this->data]);
    	exit();
    }

    public function getDetail($message_id) {
    	$request = \Request::all();
        // add system log
        $this->systemLogs('view', 'message', $request);
        // End

        $this->data->action_list = url('/message/list');
        return view('message.detail', ['data'=>$this->data]);
    }

}
