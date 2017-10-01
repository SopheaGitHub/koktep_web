<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;

use App\Http\Requests;
use Auth;

class RatingAccountController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->rating = new Rating();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'Rating';
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
    	//
    }

    public function getLoadPostRating() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_list', 'rating-account', $request);
        // End

        if($request['post_id']!='') {
        	$post_id = $request['post_id'];
        }else {
        	$post_id = 0;
        }

        $this->data->post_ratings = $this->rating->getPostRatingsByPostId($post_id)->get();
        if(count($this->data->post_ratings) > 0) {
            foreach ($this->data->post_ratings as $rating) {
                if (!empty($rating->user_profile) && is_file($this->data->dir_image . $rating->user_profile)) {
                    $this->data->thumb_user[$rating->user_id] = $this->filemanager->resize($rating->user_profile, 100, 100);
                } else {
                    $this->data->thumb_user[$rating->user_id] = $this->filemanager->resize('no_image.png', 100, 100);
                }
            }
        }

        $this->data->overview_account = url('/overview-account');
        return view('rating_account.load_post_rating', ['data' => $this->data]);
    }
}
