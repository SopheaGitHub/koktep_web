<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Language;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;

use App\Http\Requests;

class CategoryController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        // $this->middleware('auth');
        $this->data = new \stdClass();
        $this->category = new Category();
        $this->post = New Post();
        $this->language = new Language();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'Category';
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
    	$request_category = explode('-', $request['category_id']);
        $this->data->category_id = $request_category['0'];
        $this->data->category_name = ((isset($request_category['1']))? $request_category['1']:'');

        $this->data->action_list = url('/category/list?category_id='.$this->data->category_id);
        return view('category.index', ['data'=>$this->data]);
    }

    public function getList() {
        $request = \Request::all();
        if(isset($request['account_id'])) {
            $user_id = $request['account_id'];
        }else {
            $user_id = 0;
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
            'category_id' => $request['category_id'],
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

        $this->data->posts = $this->post->getPosts($filter_data)->paginate(10)->setPath(url('/category'))->appends($paginate_url);

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

        return view('category.list', ['data' => $this->data]);
    }

    public function getAutocomplete() {
        $request = \Request::all();
        $json = [];

        if (isset($request['filter_name'])) {

            $filter_data = [
                'filter_name' => $request['filter_name'],
                'sort'        => 'name',
                'order'       => 'ASC',
                'start'       => 0,
                'limit'       => 5
            ];

            $results = $this->category->getAutocompleteCategories($filter_data);

            foreach ($results as $result) {
                $json[] = [
                    'category_id' => $result->category_id,
                    'name'        => strip_tags(html_entity_decode($result->name, ENT_QUOTES, 'UTF-8'))
                ];
            }
        }

        $sort_order = [];

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        return json_encode($json);
    }
}
