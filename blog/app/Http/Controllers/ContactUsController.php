<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class ContactUsController extends Controller
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
        $this->systemLogs('view', 'contact-us', $request);
        // End

        $this->data->entry_title = trans('contactus.title');
        $this->data->entry_our_location = trans('contactus.our_location');
        $this->data->entry_team = trans('contactus.team');
        $this->data->entry_telephone = trans('contactus.telephone');
        $this->data->entry_email = trans('contactus.email');
        $this->data->entry_website = trans('contactus.website');
        $this->data->entry_address = trans('contactus.address');
        $this->data->entry_contact_form = trans('contactus.contact_form');

        $this->data->action = url('/contact-us/send');
        $this->data->action_form = url('/contact-us/contact-load-form');

        return view('contact_us', ['data'=>$this->data]);
    }

    public function getContactLoadForm() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_form', 'contact-us', $request);
        // End

        $datas = [];

        echo $this->getContactForm($datas);
        exit();
    }

    public function getContactForm($datas=[]) {

        $this->data->entry_your_name = trans('contactus.your_name');
        $this->data->entry_email = trans('contactus.email');
        $this->data->entry_message = trans('contactus.message');
        $this->data->button_send = trans('contactus.send');

        return view('contact_us_form', ['data' => $this->data]);
    }

    public function postSend() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('submit_form', 'contact-us', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $this->data->action_form = url('/contact-us/contact-load-form');

                $validationError = $this->validationForm(['request'=>$request]);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // Send message

                // End

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'create','msg'=> trans('contactus.send').' '.trans('contactus.successfully').'! <br />'.trans('contactus.text_success'), 'load_form'=>$this->data->action_form];
                return \Response::json($return);
            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    }

    public function validationForm($datas=[]) {
        $error = false;
        $rules = [
            'name'  => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ];

        $messages = [
            'name.required' => trans('contactus.name_required'),
            'email.required' => trans('contactus.email_required'),
            'email.email' => trans('contactus.email_email'),
            'message.required' => trans('contactus.message_required')
        ];

        $validator = \Validator::make($datas['request'], $rules, $messages);
        if ($validator->fails()) {
            $error = ['error'=>'1','success'=>'0','msg'=> trans('contactus.send').' '.trans('contactus.unsuccessfully').'!','validatormsg'=>$validator->messages()];
        }
        return $error;
    }

}
