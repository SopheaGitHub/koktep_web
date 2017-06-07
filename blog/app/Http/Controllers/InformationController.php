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

        $information = false;
        $information_description = false;
        if(\Request::has('information_id')) {
            $information = $this->information->getInformation($request['information_id']);

            if($information) {
                $information_description = $this->information->getInformationDescriptionByCode(['information_id'=>$request['information_id'], 'language_id'=>$request['language_id']]);
            }
            
        }

        if($information) {
            $this->data->information_id = $information->information_id;
            $this->data->icon = $information->icon;
        }else {
            $this->data->information_id = '';
            $this->data->icon = '';
        }

        if($information_description) {
            $this->data->title = $information_description->title;
            $this->data->description = $information_description->description;
        }else {
            $this->data->title = '';
            $this->data->description = '';
        }

        return view('information.detail', ['data'=>$this->data]);
    }

}
