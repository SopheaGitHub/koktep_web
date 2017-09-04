<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Message;
use App\User;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;
use Auth;
use DB;

class MessageController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        $this->middleware('auth');

        $this->data = new \stdClass();
        $this->message = new Message();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->user = New User();
        $this->data->web_title = 'Message';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->dir_image = $this->config->dir_image;
    }

    public function getIndex() {
    	$request = \Request::all();
        // add system log
        $this->systemLogs('view', 'message', $request);
        // End

        // defind zone id
        if(isset($request['load'])) {
            $load = $request['load'];
        }else {
            $load = null;
        }

        $this->data->message_inbox = $this->message->getTotalInboxByAutorId($this->data->auth_id);
        // $this->data->message_sent = $this->message->getTotalSentByAutorId($this->data->auth_id);
        $this->data->message_draft = $this->message->getTotalDraftByAutorId($this->data->auth_id);
        
        $this->data->action_url = url('/message?account_id='.$this->data->auth_id);
        $this->data->action_list = url('/message/list?account_id='.$this->data->auth_id.'&load='.$load);
        $this->data->action_list_pagination = url('/message/list');
        return view('message.index', ['data'=>$this->data]);
    }

    public function getList() {

        $request = \Request::all();
        // add system log
        $this->systemLogs('load_list', 'message', $request);
        // End

        // defind zone id
        if(isset($request['load'])) {
            $load = $request['load'];
        }else {
            $load = null;
        }

        // defind sort order
        if (isset($request['sort'])) {
            $sort = $request['sort'];
        } else {
            $sort = 'updated_at';
        }

        if (isset($request['order'])) {
            $order = $request['order'];
        } else {
            $order = 'desc';
        }

        // define filter data
        $filter_data = array(
            'load' => $load,
            'author_id' => $this->data->auth_id,
            'sort'  => 'm.'.$sort,
            'order' => 'm.'.$order
        );

        // define paginate url
        $paginate_url = [
            'load' => $load,
            'author_id' => $this->data->auth_id
        ];
        if (isset($request['sort'])) {
            $paginate_url['sort'] = $request['sort'];
        }

        if (isset($request['order'])) {
            $paginate_url['order'] = $request['order'];
        }

        $this->data->messages = $this->message->getMessages($filter_data)->paginate(3)->setPath(url('/message'))->appends($paginate_url);

        if(count($this->data->messages) > 0) {
            foreach ($this->data->messages as $message) {
                if (!empty($message->author_image) && is_file($this->data->dir_image . $message->author_image)) {
                    $this->data->thumb_user[$message->id] = $this->filemanager->resize($message->author_image, 100, 100);
                } else {
                    $this->data->thumb_user[$message->id] = $this->filemanager->resize('no_image.png', 100, 100);
                }
            }
        }

        $this->data->action_detail = url('/message/detail?account_id='.$this->data->auth_id.'&load='.$load);
        $this->data->load_title = ucfirst(trans('message.'.$load));

        $this->data->show = trans('text.show');
        $this->data->to = trans('text.to');
        $this->data->of = trans('text.of');
        $this->data->page = trans('text.page');
        $this->data->button_reply = trans('button.reply');
        $this->data->text_me = trans('message.me');
        $this->data->text_empty_message = trans('message.text_empty_message');

        return view('message.list', ['data'=>$this->data]);
        exit();
    }

    public function getDetail() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('view', 'message', $request);
        // End

        // defind zone id
        if(isset($request['load'])) {
            $load = $request['load'];
        }else {
            $load = null;
        }

        // defind zone id
        if(isset($request['message_id'])) {
            $message_id = $request['message_id'];
        }else {
            $message_id = null;
        }

        $this->data->message = $this->message->getMessage($message_id);
        if(count($this->data->message) > 0) {
            if (!empty($this->data->message->author_image) && is_file($this->data->dir_image . $this->data->message->author_image)) {
                $this->data->thumb_author = $this->filemanager->resize($this->data->message->author_image, 100, 100);
            } else {
                $this->data->thumb_author = $this->filemanager->resize('no_image.png', 100, 100);
            }

            if($load=='inbox') {
                $this->message->where('id', '=', $this->data->message->id)->update(['viewed'=>($this->data->message->viewed+1)]);
            }
        }

        $this->data->text_detail = trans('text.detail');
        $this->data->button_back = trans('button.back');
        $this->data->button_reply = trans('button.reply');
        $this->data->button_close = trans('button.close');

        $this->data->action_reply = url('/message/load-message-reply-form/'.$message_id);
        $this->data->action_back = url('/message?account_id='.$this->data->auth_id.'&load='.$load);
        $this->data->action_list = url('/message/list');
        $this->data->action_load_sub_message = url('/message/load-sub-message/'.$message_id);

        return view('message.detail', ['data'=>$this->data]);
    }

    public function getLoadMessageForm($receiver_id) {
        $receiver = [];
        if($receiver_id) {
            $receiver = $this->user->where('id', '=', $receiver_id)->first(['id', 'image', 'name']);
        }

        if(count($receiver) > 0) {
            $this->data->receiver_id = $receiver->id;
            $this->data->receiver_name = $receiver->name;
            if (!empty($receiver->image) && is_file($this->data->dir_image . $receiver->image)) {
                $this->data->receiver_image = $this->filemanager->resize($receiver->image, 100, 100);
            } else {
                $this->data->receiver_image = $this->filemanager->resize('no_image.png', 100, 100);
            }
        }else {
            $this->data->receiver_id = '0';
            $this->data->receiver_name = '';
            $this->data->receiver_image = $this->filemanager->resize('no_image.png', 100, 100);
        }

        $this->data->text_message = trans('message.message');
        $this->data->text_to = trans('message.to');
        $this->data->text_receiver = trans('message.receiver');
        $this->data->text_subject = trans('message.subject');
        $this->data->button_send = trans('button.send');
        $this->data->button_close = trans('button.close');

        $this->data->message_parent_id = '0';
        $this->data->action_send = url('/message/store/send');
        $this->data->action_draft = url('/message/store/draft');
        return view('message.form', ['data'=>$this->data]);
    }

    public function getLoadSubMessage($message_id) {
        $this->data->sub_messages = [];
        $this->data->sub_messages = $this->message->getSubMessages($message_id)->get();
        if(count($this->data->sub_messages) > 0) {
            foreach ($this->data->sub_messages as $message) {
                if (!empty($message->author_image) && is_file($this->data->dir_image . $message->author_image)) {
                    $this->data->thumb_user[$message->id] = $this->filemanager->resize($message->author_image, 100, 100);
                } else {
                    $this->data->thumb_user[$message->id] = $this->filemanager->resize('no_image.png', 100, 100);
                }
            }
        }
        return view('message.sub_detail', ['data'=>$this->data]);
        exit();
    }

    public function getLoadComposeMessageForm() {
        $this->data->receiver_id = '0';
        $this->data->message_parent_id = '0';
        $this->data->action_send = url('/message/store/send');
        $this->data->action_draft = url('/message/store/draft');

        $this->data->text_message = trans('message.message');
        $this->data->text_to = trans('message.to');
        $this->data->text_receiver = trans('message.receiver');
        $this->data->text_subject = trans('message.subject');
        $this->data->button_send = trans('button.send');
        $this->data->button_close = trans('button.close');

        return view('message.compose_form', ['data'=>$this->data]);
    }

    public function postStore($store_type) {
        $request = \Request::all();
        // add system log
        $this->systemLogs('submit_form', 'message', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                // define sender
                $request['sender_id'] = $this->data->auth_id;
                //

                // define status
                /* 
                    1 = inbox, sent
                    2 = draft
                    3 = delete
                */
                if($store_type=='send') {
                    $request['status'] = '1';
                }

                if($store_type=='reply') {
                    $request['status'] = '1';
                }

                if($store_type=='draft') {
                    $request['status'] = '2';
                }
                //

                $validationError = $this->message->validationForm(['request'=>$request, 'action'=>$store_type]);
                if($validationError) {
                    return \Response::json($validationError);
                }

                $messageDatas = [
                    'parent_id'     => $request['parent_id'],
                    'sender_id'     => $request['sender_id'],
                    'receiver_id'   => $request['receiver_id'],
                    'viewed'        => '0',
                    'subject'       => $this->escape($request['subject']),
                    'text'          => $this->escape($request['message']),
                    'status'        => ((isset($request['status']))? $request['status']:0)
                ];

                $message = $this->message->create($messageDatas);

                if($store_type=='reply') {
                    $this->message->where('id', '=', $request['parent_id'])->update(['viewed'=>'0']);
                }

                $action_load = url('/message/load-sub-message/'.$request['parent_id']);

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'create','msg'=> ucfirst(trans('message.'.$store_type.'_message')).' '.trans('text.successfully').'!', 'action_load'=>$action_load, 'display_id'=>'load-sub-message'];
                return \Response::json($return);
            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    }

    public function getLoadMessageReplyForm($message_id) {

        $new_receiver_id = false;
        $message = $this->message->getMessage($message_id);

        if(count($message) > 0) {
            if($message->sender_id == $this->data->auth_id) {
                $new_receiver_id = $message->receiver_id;
            }

            if($message->receiver_id == $this->data->auth_id) {
                $new_receiver_id = $message->sender_id;
            }
        }

        $receiver = [];
        if($new_receiver_id) {
            $receiver = $this->user->where('id', '=', $new_receiver_id)->first(['id', 'image', 'name']);
        }

        if(count($receiver) > 0) {
            $this->data->receiver_id = $receiver->id;
            $this->data->receiver_name = $receiver->name;
            if (!empty($receiver->image) && is_file($this->data->dir_image . $receiver->image)) {
                $this->data->receiver_image = $this->filemanager->resize($receiver->image, 100, 100);
            } else {
                $this->data->receiver_image = $this->filemanager->resize('no_image.png', 100, 100);
            }
        }else {
            $this->data->receiver_id = '0';
            $this->data->receiver_name = '';
            $this->data->receiver_image = $this->filemanager->resize('no_image.png', 100, 100);
        }

        $this->data->text_message = trans('message.message');
        $this->data->text_to = trans('message.to');
        $this->data->text_receiver = trans('message.receiver');
        $this->data->text_subject = trans('message.subject');
        $this->data->button_send = trans('button.send');
        $this->data->button_reply = trans('button.reply');
        $this->data->button_close = trans('button.close');
        
        $this->data->message_parent_id = $message_id;
        $this->data->action_reply = url('/message/store/reply');
        return view('message.reply_form', ['data'=>$this->data]);
    }

}
