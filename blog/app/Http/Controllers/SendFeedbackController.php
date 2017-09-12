<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class SendFeedbackController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->data->web_title = 'Send Feedback';
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
        $this->systemLogs('view', 'send-feedback', $request);
        // End

        $this->data->entry_title = trans('sendfeedback.title');
        $this->data->entry_our_location = trans('sendfeedback.our_location');
        $this->data->entry_team = trans('sendfeedback.team');
        $this->data->entry_telephone = trans('sendfeedback.telephone');
        $this->data->entry_email = trans('sendfeedback.email');
        $this->data->entry_website = trans('sendfeedback.website');
        $this->data->entry_address = trans('sendfeedback.address');
        $this->data->entry_sendfeedback_form = trans('sendfeedback.sendfeedback_form');
        $this->data->text_feedback = trans('sendfeedback.text_feedback');

        $this->data->action = url('/send-feedback/send');
        $this->data->action_form = url('/send-feedback/sendfeedback-load-form');

        return view('send_feedback', ['data'=>$this->data]);
    }

    public function getSendfeedbackLoadForm() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_form', 'send-feedback', $request);
        // End

        $datas = [];

        echo $this->getSendfeedbackForm($datas);
        exit();
    }

    public function getSendfeedbackForm($datas=[]) {

        $this->data->entry_your_name = trans('sendfeedback.your_name');
        $this->data->entry_email = trans('sendfeedback.email');
        $this->data->entry_message = trans('sendfeedback.message');
        $this->data->button_send = trans('sendfeedback.send');

        $this->data->auth_name = (( \Auth::check() )? \Auth::user()->name:'' );
        $this->data->auth_email = (( \Auth::check() )? \Auth::user()->email:'' );

        return view('send_feedback_form', ['data' => $this->data]);
    }

    public function postSend() {
        $request = \Request::all();
        
        // add system log
        $this->systemLogs('submit_form', 'send-feedback', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $this->data->action_form = url('/send-feedback/sendfeedback-load-form');

                $validationError = $this->validationForm(['request'=>$request]);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // Send feedback
                $dataPosts = [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'message' => $request['message']
                ];
                \Mail::send('emails.feedback', ['datas'=>$dataPosts], function($message) use ($request)
                {
                    $message->to('teamkoktep@gmail.com', 'team koktep')->subject('Visitor: '.$request['name'].' feedback!' );
                });
                // End

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'create','msg'=> trans('sendfeedback.send').' '.trans('sendfeedback.successfully').'! <br />'.trans('sendfeedback.text_success'), 'load_form'=>$this->data->action_form];
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
            'name.required' => trans('sendfeedback.name_required'),
            'email.required' => trans('sendfeedback.email_required'),
            'email.email' => trans('sendfeedback.email_email'),
            'message.required' => trans('sendfeedback.message_required')
        ];

        $validator = \Validator::make($datas['request'], $rules, $messages);
        if ($validator->fails()) {
            $error = ['error'=>'1','success'=>'0','msg'=> trans('sendfeedback.send').' '.trans('sendfeedback.unsuccessfully').'!','validatormsg'=>$validator->messages()];
        }
        return $error;
    }

}
