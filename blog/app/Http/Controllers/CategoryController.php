<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');
        $this->data = new \stdClass();
        $this->data->web_title = 'Category';
    }

    /**
     * Show the application account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
    	$request = \Request::all();
    	$request_category = explode('-', $request['category_id']);
        $this->data->category_id = $request_category['0'];
        $this->data->category_name = ((isset($request_category['1']))? $request_category['1']:'');

        $this->data->action_list = url('/post-account/list?category_id='.$this->data->category_id);
        $this->data->action_paginate_list = url('/post-account/list');
        return view('category.index', ['data'=>$this->data]);
    }

}
