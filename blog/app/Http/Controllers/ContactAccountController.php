<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Country;
use App\Models\Zone;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;

use App\Http\Requests;
use Auth;

class ContactAccountController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->user = New User();
        $this->country = new Country();
        $this->zone = new Zone();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'About';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->dir_image = $this->config->dir_image;
    }

    /**
     * Show the application contact account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $request = \Request::all();
        // add system log
        $this->systemLogs('view', 'contact-account', $request);
        // End
        if(isset($request['account_id'])) {
            $this->data->action_list = url('/contact-account/list?account_id='.$request['account_id']);
            return view('contact_account.index', ['data'=>$this->data]);
        }else {
            return view('errors.503');
        }
    }

    public function getList() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_list', 'contact-account', $request);
        // End
        if(isset($request['account_id'])) {
            $user_id = $request['account_id'];
        }else {
            $user_id = 0;
        }

        $this->data->countries = $this->country->getCountries(['sort'=>'name','order'=>'asc'])->lists('name', 'country_id');
        $this->data->zones = $this->zone->getZones(['sort'=>'name','order'=>'asc'])->lists('name', 'zone_id');

        $this->data->user_address = $this->user->getAddressByUserId($user_id);

        $this->data->entry_contact_name = trans('text.entry_contact_name');
        $this->data->entry_address = trans('text.entry_address');
        $this->data->entry_company = trans('text.entry_company');
        $this->data->entry_address = trans('text.entry_address');
        $this->data->entry_postcode = trans('text.entry_postcode');
        $this->data->entry_phone = trans('text.entry_phone');
        $this->data->entry_fax = trans('text.entry_fax');
        $this->data->entry_email = trans('text.entry_email');
        $this->data->entry_website = trans('text.entry_website');

        $this->data->text_empty = '...';

        return view('contact_account.list', ['data' => $this->data]);
    }
}
