<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class OverviewAccountController extends Controller
{

    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->data->web_title = 'Overview';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
    }

    /**
     * Show the application account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $request = \Request::all();
        // add system log
        $this->systemLogs('view', 'overview-account', $request);
        // End
        if(isset($request['account_id'])) {
            $this->data->action_list = url('/post-account/list?account_id='.$request['account_id']);
            $this->data->action_paginate_list = url('/post-account/list');
            return view('overview_account.index', ['data'=>$this->data]);
        }else {
            if(isset($request['login'])&&$request['login']=='success'&&Auth::check()) {
                \Request::merge(['account_id' => $this->data->auth_id]);

                if(\Session::has('return_detail')) {
                    $store_return_detail = \Session::get('return_detail');
                    \Session::forget('return_detail');
                    return redirect($store_return_detail);
                }

                $this->data->action_list = url('/post-account/list?account_id='.((Auth::check())? Auth::user()->id:'0'));
                $this->data->action_paginate_list = url('/post-account/list');
                return view('overview_account.index', ['data'=>$this->data]);
            }else {
                return view('errors.503');
            }
        }
    }
}
