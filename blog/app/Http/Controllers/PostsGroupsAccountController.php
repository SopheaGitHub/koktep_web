<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostGroup;
use App\Models\Language;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;

use App\Http\Requests;
use DB;
use Auth;

class PostsGroupsAccountController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');

        $this->data = new \stdClass();
        $this->post = New Post();
        $this->post_group = New PostGroup();
        $this->language = new Language();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'Posts Groups';
        $this->data->auth_id = ((Auth::check())? Auth::user()->id:'0');
        $this->data->dir_image = $this->config->dir_image;
    }

    /**
     * Show the application account profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $request = \Request::all();
        if(isset($request['account_id'])) {
            $this->data->action_list = url('/posts-groups-account/list?account_id='.$request['account_id']);
            $this->data->action_paginate_list = url('/posts-groups-account/list');
            return view('post_group_account.index', ['data'=>$this->data]);
        }else {
            return view('errors.503');
        }
    }

    public function getList() {
        $request = \Request::all();
        $this->data->edit_post = url('/posts/edit');
        $this->data->action_delete = url('/posts/delete');

        // define account id
        if(isset($request['account_id'])) {
            $user_id = $request['account_id'];
        }else {
            $user_id = null;
        }

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
        	'account_id'=>$user_id,
            'sort'  => $sort,
            'order' => $order
        );

        // define paginate url
        $paginate_url = ['account_id'=>$user_id];
        if (isset($request['sort'])) {
            $paginate_url['sort'] = $request['sort'];
        }

        if (isset($request['order'])) {
            $paginate_url['order'] = $request['order'];
        }

        $this->data->posts_groups = $this->post_group->getPostsGroups($filter_data)->paginate(10)->setPath(url('/posts-groups-account'))->appends($paginate_url);

        $this->data->post_group_items = [];
        if(count($this->data->posts_groups) > 0) {
        	foreach ($this->data->posts_groups as $posts_groups_info) {
        		$array_post_group_value = json_decode($posts_groups_info->value, true);

        		// get post group item
        		$post_group_items = $this->post->getPostsByPostGroup(['array_post_group_id'=>$array_post_group_value])->get();
        		if(count($post_group_items) > 0) {
        			foreach ($post_group_items as $post_group_items_info) {

        				if (!empty($post_group_items_info->image) && is_file($this->data->dir_image . $post_group_items_info->image)) {
		                    $thumb = $this->filemanager->resize($post_group_items_info->image, 120, 80);
		                } else {
		                    $thumb = $this->filemanager->resize('no_image.png', 120, 80);
		                }

        				$this->data->post_group_items[$posts_groups_info->post_group_id][] = [
        					'author_id' => $post_group_items_info->author_id,
        					'post_id'	=> $post_group_items_info->post_id,
        					'category_id' => $post_group_items_info->category_id,
        					'category_name' => $post_group_items_info->category_name,
        					'thumb'		=> $thumb
        				];
        			}
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
        $this->data->post_detail = url('/post-account/detail');
        $this->data->text_empty = '...';

        return view('post_group_account.list', ['data' => $this->data]);
    }

}
