<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;

use App\Http\Requests;
use Auth;

class AboutAccountController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->user = New User();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'About';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->dir_image = $this->config->dir_image;
    }

    /**
     * Show the application about account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $request = \Request::all();
        if(isset($request['account_id'])) {
            $this->data->action_list = url('/about-account/list?account_id='.$request['account_id']);
            return view('about_account.index', ['data'=>$this->data]);
        }else {
            return view('errors.503');
        }
    }

    public function getList() {
        $request = \Request::all();
        if(isset($request['account_id'])) {
            $user_id = $request['account_id'];
        }else {
            $user_id = 0;
        }

        $this->data->go_contact = url('/contact-account?account_id='.$user_id);

        $this->data->user = $this->user->getUser($user_id);
        $this->data->user_technicals = $this->user->getTechnicalByUserId($user_id);

        if($this->data->user) {
            $this->data->description = $this->data->user->description;
        }else {
            $this->data->description = '';
        }

        if (isset($this->data->user->first_cover) && is_file($this->data->dir_image . $this->data->user->first_cover)) {
            $this->data->thumb_first_cover = $this->filemanager->resize($this->data->user->first_cover, 600, 400);
        } else {
            $this->data->thumb_first_cover = $this->filemanager->resize('no_image.png', 600, 400);
        }

        if (isset($this->data->user->second_cover) && is_file($this->data->dir_image . $this->data->user->second_cover)) {
            $this->data->thumb_second_cover = $this->filemanager->resize($this->data->user->second_cover, 600, 400);
        } else {
            $this->data->thumb_second_cover = $this->filemanager->resize('no_image.png', 600, 400);
        }

        return view('about_account.list', ['data' => $this->data]);
        
    }

}
