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
        $this->data->web_title = 'Contact Us';
    }

    public function getLoadMessageForm() {
    	return view('message.form', ['data' => $this->data]);
        exit();
    }

}
