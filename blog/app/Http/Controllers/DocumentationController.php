<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documentation;
use App\Models\Language;

use App\Http\Requests;

class DocumentationController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->documentation = new Documentation();
        $this->language = new Language();
        $this->data->web_title = 'Documentation';
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

        $this->data->action_list = url('/documentation/list');
        $this->data->action_paginate_list = url('/documentation/list');
        return view('documentation.index', ['data'=>$this->data]);
    }

    public function getList()
    {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_list', 'documentation', $request);
        // End
        if(isset($request['documentation_id'])) {
            $documentation_id = $request['documentation_id'];
        }else {
            $documentation_id = 1;
        }

        if(\Session::has('locale')) {
            $locale = \Session::get('locale');
        }else {
            $locale = 'en';
        }
        $language_id = '1';
        $language = $this->language->getLanguageByCode( $locale );

        if($language) {
            $language_id = $language->language_id;
        }

        $documentation_descriptions = $this->documentation->getDocumentationDescriptionsByLanguage($documentation_id, $language_id);

        if($documentation_descriptions) {
            $this->data->documentation_descriptions_name = $documentation_descriptions->name;
            $this->data->documentation_descriptions_description = $documentation_descriptions->description;
        }else {
            $this->data->documentation_descriptions_name = '';
            $this->data->documentation_descriptions_description = '';
        }

        return view('documentation.list', ['data'=>$this->data]);
    }

}
