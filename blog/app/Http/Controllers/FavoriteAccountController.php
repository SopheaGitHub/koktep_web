<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;

use App\Http\Requests;
use Auth;

class FavoriteAccountController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->favorite = new Favorite();
        $this->data->web_title = 'Favorite';
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
        // add system log
        $this->systemLogs('view', 'favorite-account', $request);
        // End
    	$this->data->action_list = url('/favorite-account/list?account_id='.$request['account_id']);
    	return view('favorite_account.index', ['data' => $this->data]);
    }

    public function getList() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_list', 'favorite-account', $request);
        // End

        return view('favorite_account.list', ['data' => $this->data]);
    }

    public function getLoadPostFavorite() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_list', 'favorite-account', $request);
        // End

        if($request['post_id']!='') {
            $post_id = $request['post_id'];
        }else {
            $post_id = 0;
        }

        $this->data->post_favorites = $this->favorite->getPostFavoriteByPostId($post_id)->get();
        if(count($this->data->post_favorites) > 0) {
            foreach ($this->data->post_favorites as $favorite) {
                if (!empty($favorite->user_profile) && is_file($this->data->dir_image . $favorite->user_profile)) {
                    $this->data->thumb_user[$favorite->user_id] = $this->filemanager->resize($favorite->user_profile, 100, 100);
                } else {
                    $this->data->thumb_user[$favorite->user_id] = $this->filemanager->resize('no_image.png', 100, 100);
                }
            }
        }

        $this->data->overview_account = url('/overview-account');
        return view('favorite_account.load_post_favorite', ['data' => $this->data]);
    }

}
