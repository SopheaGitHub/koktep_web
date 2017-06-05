<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LanguageController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->data->web_title = 'Language';
    }

    public function switcher() {

        if(!\Session::has('locale'))
        {
            \Session::put('locale', \Request::get('locale'));
        }else {
            \Session::set('locale', \Request::get('locale'));
        }
        
        return \Redirect::back();
    }

}
