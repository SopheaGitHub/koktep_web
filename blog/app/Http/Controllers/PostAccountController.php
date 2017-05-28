<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;

use App\Http\Requests;
use DB;
use Auth;

class PostAccountController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        $this->middleware('auth');

        $this->data = new \stdClass();
        $this->post = New Post();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'Overview';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->dir_image = $this->config->dir_image;
    }

    public function getDetail() {
        $request = \Request::all();
        $this->data->go_back = \URL::previous();
        return view('post_account.detail', ['data' => $this->data]);
    }

    public function getList() {
        $request = \Request::all();
        // define account id
        if(isset($request['account_id'])) {
            $user_id = $request['account_id'];
        }else {
            $user_id = null;
        }

        // defind category id
        if(isset($request['category_id'])) {
            $category_id = $request['category_id'];
        }else {
            $category_id = null;
        }

        // defind search title, description, tag
        if(isset($request['search'])) {
            $search = $request['search'];
        }else {
            $search = null;
        }

        $this->data->overview_account = url('/overview-account');
        $this->data->post_detail = url('/post-account/detail');

        // define data filter
        if (isset($request['sort'])) {
            $sort = $request['sort'];
        } else {
            $sort = 'created_at';
        }

        if (isset($request['order'])) {
            $order = $request['order'];
        } else {
            $order = 'desc';
        }

        // define filter data
        $filter_data = array(
            'author_id' => $user_id,
            'category_id' => $category_id,
            'search'    => $search,
            'sort'  => $sort,
            'order' => $order
        );

        // define paginate url
        $paginate_url = ['account_id'=>$user_id, 'category_id'=>$category_id];
        if (isset($request['sort'])) {
            $paginate_url['sort'] = $request['sort'];
        }

        if (isset($request['order'])) {
            $paginate_url['order'] = $request['order'];
        }

        $this->data->posts = $this->post->getPosts($filter_data)->paginate(1)->setPath(url('/post-account'))->appends($paginate_url);

        if(count($this->data->posts) > 0) {
            foreach ($this->data->posts as $post) {
                if (!empty($post->image) && is_file($this->data->dir_image . $post->image)) {
                    $this->data->thumb[$post->post_id] = $this->filemanager->resize($post->image, 600, 400);
                } else {
                    $this->data->thumb[$post->post_id] = $this->filemanager->resize('no_image.png', 600, 400);
                }
            }
        }

        // define data
        $this->data->sort = $sort;
        $this->data->order = $order;

        // define column sort
        $url = '';
        if ($order == 'asc') {
            $url .= '&order=desc';
        } else {
            $url .= '&order=asc';
        }

        if (isset($request['page'])) {
            $url .= '&page='.$request['page'];
        }

        $this->data->status = $this->config->status;

        $this->data->text_empty = 'There is no data!';

        return view('post_account.list', ['data' => $this->data]);
    }
}
