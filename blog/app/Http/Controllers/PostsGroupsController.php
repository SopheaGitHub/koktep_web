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

class PostsGroupsController extends Controller
{
    protected $data = null;

    public function __construct()
    {
        $this->middleware('auth');

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
     * Show the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
    	$this->data->action_list = url('/posts-groups/list');
        $this->data->add_post_group = url('/posts-groups/create');
        return view('post_group.index', ['data'=>$this->data]);
    }

    public function getList() {
        $request = \Request::all();
        $this->data->edit_post = url('/posts/edit');
        $this->data->action_delete = url('/posts/delete');

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
            'sort'  => $sort,
            'order' => $order
        );

        // define paginate url
        $paginate_url = ['account_id'=>$this->data->auth_id];
        if (isset($request['sort'])) {
            $paginate_url['sort'] = $request['sort'];
        }

        if (isset($request['order'])) {
            $paginate_url['order'] = $request['order'];
        }

        $this->data->posts_groups = $this->post_group->getPostsGroups($filter_data)->paginate(10)->setPath(url('/posts-groups'))->appends($paginate_url);

        $this->data->post_group_items = [];
        if(count($this->data->posts_groups) > 0) {
        	foreach ($this->data->posts_groups as $posts_groups_info) {
        		$array_post_group_value = json_decode($posts_groups_info->value, true);

        		// get post group item
        		$post_group_items = $this->post->getPosts(['sort'=>'created_at', 'order'=>'desc'])->get();
        		if(count($post_group_items) > 0) {
        			foreach ($post_group_items as $post_group_items_info) {

        				if (!empty($post_group_items_info->image) && is_file($this->data->dir_image . $post_group_items_info->image)) {
		                    $thumb = $this->filemanager->resize($post_group_items_info->image, 120, 80);
		                } else {
		                    $thumb = $this->filemanager->resize('no_image.png', 120, 80);
		                }

        				$this->data->post_group_items[$posts_groups_info->post_group_id][] = [
        					'post_id'	=> $post_group_items_info->post_id,
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

        $this->data->text_empty = 'There is no data!';

        return view('post_group.list', ['data' => $this->data]);
    }

    /**
     * Show the form for creating a new post group.
     *
     * @return Response
     */
    public function getCreate()
    {
    	$this->data->go_back = url('/posts-groups');
        $this->data->action_form = url('/posts-groups/create-load-form');
        return view('post_group.create', ['data'=>$this->data]);
    }

    public function getCreateLoadForm() {
        $datas = [
            'action' => url('/posts-groups/store'),
            'titlelist' => 'Add New Post Group'
        ];
        echo $this->getPostGroupForm($datas);
        exit();
    }

    /**
     * Store a newly created post in storage.
     *
     * @return Response
     */
    public function postStore()
    {
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $request = \Request::all();
                $this->data->action_form = url('/posts-groups/create-load-form');

                $validationError = $this->post_group->validationForm(['request'=>$request]);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // insert post group
                $postDatas = [
                    'value'     => json_encode(((isset($request['post_related']))? $request['post_related']:[])),
                    'status'	=> $request['status']
                ];

                $post_group = $this->post_group->create($postDatas);
                // End

                // insert post group description
                $post_group_descriptionDatas = [
                    'post_group_id'       => $post_group->id,
                    'post_group_description_datas'    => $request['post_group_description']
                ];

                $post_group_description = $this->post_group->insertPostGroupDescription($post_group_descriptionDatas);
                // End

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'create','msg'=>'Success : save post successfully!', 'load_form'=>$this->data->action_form];
                return \Response::json($return);
            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    }

    public function getPostGroupForm($datas=[]) {
        $this->data->go_post_autocomplete = url('/posts/autocomplete');
        $this->data->languages = $this->language->getLanguages(['sort'=>'name', 'order'=>'asc'])->get();
        $this->data->status = $this->config->status;
        $this->data->post_relateds = [];

        // define tap
        $this->data->tab_general = 'General';
        $this->data->tab_data = 'Data';

        // define entry
        $this->data->entry_name = 'Post Group Name';
        $this->data->entry_image = 'Image';
        $this->data->entry_status = 'Status';
        $this->data->entry_sort_order = 'Sort Order';

        $this->data->entry_related = 'Posts';

        // define input title
        $this->data->title_related = '(Autocomplete)';

        $this->data->button_remove = 'Remove';
        $this->data->button_image_add = 'Add Image';

        if(isset($datas['post'])) {
            $this->data->image = $datas['post']->image;
            $this->data->sort_order = $datas['post']->sort_order;
            $this->data->post_status = $datas['post']->status;
            $this->data->keyword = $datas['post']->keyword;
        }else {
            $this->data->image = '';
            $this->data->sort_order = '0';
            $this->data->post_status = '1';
            $this->data->keyword = '';
        }

        if(isset($datas['post_descriptions'])) {
            foreach ($datas['post_descriptions'] as $description) {
                $this->data->post_description[$description->language_id]['name'] = $description->name;
                $this->data->post_description[$description->language_id]['description'] = $description->description;
                $this->data->post_description[$description->language_id]['meta_title'] = $description->meta_title;
                $this->data->post_description[$description->language_id]['meta_description'] = $description->meta_description;
                $this->data->post_description[$description->language_id]['meta_keyword'] = $description->meta_keyword;
                $this->data->post_description[$description->language_id]['tag'] = $description->tag;
            }
        }else {
            foreach ($this->data->languages as $language) {
                $this->data->post_description[$language->language_id]['name'] = '';
                $this->data->post_description[$language->language_id]['description'] = '';
                $this->data->post_description[$language->language_id]['meta_title'] = '';
                $this->data->post_description[$language->language_id]['meta_description'] = '';
                $this->data->post_description[$language->language_id]['meta_keyword'] = '';
                $this->data->post_description[$language->language_id]['tag'] = '';
            }
        }

        $this->data->action = (($datas['action'])? $datas['action']:'');
        $this->data->titlelist = (($datas['titlelist'])? $datas['titlelist']:'');

        return view('post_group.form', ['data' => $this->data]);
    }
}
