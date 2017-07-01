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
        $request = \Request::all();
        // add system log
        $this->systemLogs('view', 'posts-groups', $request);
        // End
        if(\Request::get('account_id')!=$this->data->auth_id) {
            return view('errors.504');
        }

        $this->data->text_title = trans('text.posted_groups_management');
        $this->data->button_add = trans('button.add');

    	$this->data->action_list = url('/posts-groups/list');
        $this->data->action_delete = url('/posts-groups/delete');
        $this->data->add_post_group = url('/posts-groups/create');
        return view('post_group.index', ['data'=>$this->data]);
    }

    public function getList() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_list', 'posts-groups', $request);
        // End
        $this->data->edit_post = url('/posts-groups/edit');

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
            'account_id'=>$this->data->auth_id,
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
                            'post_id'   => $post_group_items_info->post_id,
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

        $this->data->delete_confirmation = trans('text.delete_confirmation');
        $this->data->delete_confirmation_message = trans('text.delete_confirmation_message');
        $this->data->show = trans('text.show');
        $this->data->to = trans('text.to');
        $this->data->of = trans('text.of');
        $this->data->page = trans('text.page');

        $this->data->button_edit = trans('button.edit');
        $this->data->button_delete = trans('button.delete');
        $this->data->button_yes = trans('button.yes');
        $this->data->button_no = trans('button.no');

        $this->data->status = $this->status();
        $this->data->post_detail = url('/post-account/detail');
        $this->data->text_empty = '...';

        return view('post_group.list', ['data' => $this->data]);
    }

    /**
     * Show the form for creating a new post group.
     *
     * @return Response
     */
    public function getCreate()
    {
        $request = \Request::all();
        // add system log
        $this->systemLogs('create', 'posts-groups', $request);
        // End

        $this->data->text_title = trans('text.posted_groups_management');

        $this->data->button_cancel = trans('button.cancel');
        $this->data->button_save = trans('button.save');

    	$this->data->go_back = url('/posts-groups');
        $this->data->action = url('/posts-groups/store');
        $this->data->action_form = url('/posts-groups/create-load-form');
        return view('post_group.create', ['data'=>$this->data]);
    }

    public function getCreateLoadForm() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_form', 'posts-groups', $request);
        // End
        $datas = [
            'icon' => 'icon_create',
            'titlelist' => trans('button.add')
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
        $request = \Request::all();
        // add system log
        $this->systemLogs('submit_form', 'posts-groups', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $this->data->action_form = url('/posts-groups/create-load-form');

                $validationError = $this->post_group->validationForm(['request'=>$request, 'action'=>'create']);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // insert post group
                $postGroupDatas = [
                    'author_id'     => $this->data->auth_id,
                    'value'     => json_encode(((isset($request['post_related']))? $request['post_related']:[])),
                    'status'	=> $request['status']
                ];

                $post_group = $this->post_group->create($postGroupDatas);
                // End

                // insert post group description
                $post_group_descriptionDatas = [
                    'post_group_id'       => $post_group->id,
                    'post_group_description_datas'    => $request['post_group_description']
                ];

                $post_group_description = $this->post_group->insertPostGroupDescription($post_group_descriptionDatas);
                // End

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'create','msg'=> trans('text.save').' '.trans('text.successfully').'!', 'load_form'=>$this->data->action_form];
                return \Response::json($return);
            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($post_group_id)
    {
        $request = \Request::all();
        // add system log
        $this->systemLogs('edit', 'posts-groups', $request);
        // End

        $this->data->text_title = trans('text.posted_groups_management');

        $this->data->button_cancel = trans('button.cancel');
        $this->data->button_save_change = trans('button.save_change');

        $this->data->go_back = url('/posts-groups');
        $this->data->action = url('/posts-groups/update/'.$post_group_id);
        $this->data->action_form = url('/posts-groups/edit-load-form/'.$post_group_id);
        return view('post_group.edit', ['data'=>$this->data]);
    }

    public function getEditLoadForm($post_group_id) {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_form', 'posts-groups', $request);
        // End
        $this->data->post_group = $this->post_group->getPostGroup($post_group_id);
        $this->data->post_group_descriptions = $this->post_group->getPostGroupDescriptions($post_group_id);

        $data['post_relateds'] = [];
        if(count($this->data->post_group) > 0) {

            $array_post_group_value = json_decode($this->data->post_group->value, true);

            // get post group item
            $post_relateds = $this->post->getPostsByPostGroup(['array_post_group_id'=>$array_post_group_value])->get();
            if(count($post_relateds) > 0) {
                foreach ($post_relateds as $related_info) {
                    $data['post_relateds'][] = [
                        'post_id' => $related_info->post_id,
                        'title'   => $related_info->title
                    ];
                }
            }
        
        }        

        $datas = [
            'icon' => 'icon_edit',
            'titlelist' => trans('button.edit'),
            'post_group' => $this->data->post_group,
            'post_group_descriptions' => $this->data->post_group_descriptions,
            'post_relateds'  => $data['post_relateds']
        ];

        echo $this->getPostGroupForm($datas);
        exit();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postUpdate($post_group_id)
    {
        $request = \Request::all();
        // add system log
        $this->systemLogs('submit_form', 'posts-groups', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $validationError = $this->post_group->validationForm(['request'=>$request, 'action'=>'edit']);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // update post group
                $postGroupDatas = [
                    'updated_by_author_id'  => $this->data->auth_id,
                    'value'     => json_encode(((isset($request['post_related']))? $request['post_related']:[])),
                    'status'    => $request['status']
                ];

                $post_group = $this->post_group->where('post_group_id', '=', $post_group_id)->update($postGroupDatas);
                // End

                // update post group description
                $clear_post_group_description = $this->post_group->deletedPostGroupDescription($post_group_id);
                $post_group_descriptionDatas = [
                    'post_group_id'       => $post_group_id,
                    'post_group_description_datas'    => $request['post_group_description']
                ];

                $post_group_description = $this->post_group->insertPostGroupDescription($post_group_descriptionDatas);
                // End

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'edit','msg'=> trans('text.save_change').' '.trans('text.successfully').'!', 'load_form'=>'none'];
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
        $this->data->status = $this->status();

        // define tap
        $this->data->tab_general = trans('text.tab_general');
        $this->data->tab_data = trans('text.tab_data');

        // define entry
        $this->data->entry_name = trans('text.entry_name');
        $this->data->entry_image = trans('text.entry_image');
        $this->data->entry_status = trans('text.entry_status');
        $this->data->entry_sort_order = trans('text.entry_sort_order');

        $this->data->entry_related = trans('text.entry_related');

        // define input title
        $this->data->title_related = trans('text.autocomplete');

        $this->data->button_remove = trans('text.button_remove');
        $this->data->button_image_add = trans('text.button_image_add');

        if(isset($datas['post_group'])) {
            $this->data->sort_order = $datas['post_group']->sort_order;
            $this->data->post_status = $datas['post_group']->status;
        }else {
            $this->data->sort_order = '0';
            $this->data->post_status = '1';
        }

        if(isset($datas['post_group_descriptions'])) {
            foreach ($datas['post_group_descriptions'] as $description) {
                $this->data->post_group_description[$description->language_id]['name'] = $description->name;
            }
        }else {
            foreach ($this->data->languages as $language) {
                $this->data->post_group_description[$language->language_id]['name'] = '';
            }
        }

        if(isset($datas['post_relateds'])) {
            $this->data->post_relateds = $datas['post_relateds'];
        }else {
            $this->data->post_relateds = [];
        }
        
        $this->data->titlelist = (($datas['titlelist'])? $datas['titlelist']:'');
        $this->data->icon = (($datas['icon'])? $datas['icon']:'');

        return view('post_group.form', ['data' => $this->data]);
    }

    public function postDelete() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('delete', 'posts-groups', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $post_group = $this->post_group->where('post_group_id', '=', $request['post_group_id'])->first();
                if($post_group) {
                    $request['post_group_invalid'] = 'true';
                    $request['post_group_author_id'] = $post_group->author_id;
                }else {
                    $request['post_group_invalid'] = '';
                    $request['post_group_author_id'] = '0';
                }
                
                $request['author_id'] = $this->data->auth_id;
                $this->data->action_list = url('/posts-groups/list');

                $validationError = $this->post_group->validationDeleteForm(['request'=>$request, 'action'=>'delete']);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // delete old post
                $this->post_group->where('post_group_id', '=', $request['post_group_id'])->delete();
                $this->post_group->deletedPostGroupDescription($request['post_group_id']);
                // End

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'delete','msg'=> trans('text.delete').' '.trans('text.successfully').'!', 'load_form'=>$this->data->action_list];
                return \Response::json($return);

            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    }

}
