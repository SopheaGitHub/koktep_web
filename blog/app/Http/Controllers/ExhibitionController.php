<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;
use Auth;

class ExhibitionController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        $this->middleware('auth');

        $this->data = new \stdClass();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'Exhibition';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->dir_image = $this->config->dir_image;
        $this->data->http_best_path = $this->config->http_best_path;
    }

    public function getIndex() {
        return view('exhibition.index', ['data'=>$this->data]);
    }

    public function getRequest() {
    	return view('exhibition.request_form', ['data'=>$this->data]);
    }

}
