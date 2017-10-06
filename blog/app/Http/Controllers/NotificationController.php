<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;
use App\Models\Notification;
use App\Models\NotificationViewed;
use App\Models\Language;
use Auth;
use DB;

class NotificationController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        $this->middleware('auth');

        $this->data = new \stdClass();
        $this->notification = new Notification();
        $this->notification_viewed = new NotificationViewed();
        $this->language = new Language();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->user = New User();
        $this->data->web_title = 'Notification';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->dir_image = $this->config->dir_image;
    }

    public function getIndex() {
    	$request = \Request::all();
        // add system log
        $this->systemLogs('view', 'notification', $request);
        // End

        $this->data->text_title = 'Notifications';
        $this->data->action_list = url('/notification/list?account_id='.$this->data->auth_id);
        $this->data->action_list_pagination = url('/notification/list');
        return view('notification.index', ['data'=>$this->data]);
    }

    public function getList() {
    	$request = \Request::all();
        // add system log
        $this->systemLogs('load_list', 'notification', $request);
        // End

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

        $getLastViewedDate = $this->notification_viewed->where('user_id', '=', $this->data->auth_id)->orderBy('updated_at', 'desc')->first(['updated_at']);
		
		// define filter data
        $filter_data = array(
            'last_notification_viewed_date'=> (($getLastViewedDate)? $getLastViewedDate->updated_at:'')
        );

        // define paginate url
        $paginate_url = [
            'last_notification_viewed_date'=> (($getLastViewedDate)? $getLastViewedDate->updated_at:'')
        ];

        if (isset($request['sort'])) {
            $paginate_url['sort'] = $request['sort'];
        }

        if (isset($request['order'])) {
            $paginate_url['order'] = $request['order'];
        }

        $this->data->notifications = $this->notification->getAllNotifications($this->data->auth_id, $language_id, $filter_data)->paginate(10)->setPath(url('/notification'))->appends($paginate_url);
        
        if(count($this->data->notifications) > 0) {
	        foreach ($this->data->notifications as $notification) {
	            if (!empty($notification->user_profile) && is_file($this->config->dir_image . $notification->user_profile)) {
	                $this->data->notification_thumb_user[$notification->id] = $this->filemanager->resize($notification->user_profile, 100, 100);
	            } else {
	                $this->data->$notification_thumb_user[$notification->id] = $this->filemanager->resize('no_image.png', 100, 100);
	            }
	        }
	    }

	    $this->data->show = trans('text.show');
        $this->data->to = trans('text.to');
        $this->data->of = trans('text.of');
        $this->data->page = trans('text.page');

        return view('notification.list', ['data'=>$this->data]);
    }

    public function getClearViewed() {

    	$request = \Request::all();
        // add system log
        $this->systemLogs('submit_form', 'notification', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

            	if($request['account_id']!='') {
		            $account_id = $request['account_id'];
		        }else {
		            $account_id = 0;
		        }

		    	$viewed = $this->notification_viewed->where('user_id', '=', $account_id)->orderBy('updated_at', 'desc')->first();
		    	if($viewed) {
		    		$notification = $this->notification_viewed->where('user_id', '=', $account_id)->update(['user_id'=>$account_id]);
		    	}else {
		    		$notification = $this->notification_viewed->create(['user_id' => $account_id]);
		    	}

                DB::commit();
                exit();
            } catch (Exception $e) {
                DB::rollback();
                // echo $e->getMessage();
                exit();
            }
        }
        exit();
    }

}
