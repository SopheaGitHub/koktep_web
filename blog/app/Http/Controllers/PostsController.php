<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostDeleted;
use App\Models\Language;
use App\Models\Layout;
use App\Models\UrlAlias;
use App\Models\Category;
use App\User;
use App\Http\Controllers\Common\FilemanagerController;
use App\Http\Controllers\ConfigController;

use App\Http\Requests;
use DB;
use Auth;

class PostsController extends Controller
{

    protected $data = null;

    public function __construct()
    {
        $this->middleware('auth');

        $this->data = new \stdClass();
        $this->post = New Post();
        $this->post_comment = new PostComment();
        $this->post_deleted = new PostDeleted();
        $this->language = new Language();
        $this->layout = new Layout();
        $this->url_alias = new UrlAlias();
        $this->category = new Category();
        $this->user = New User();
        $this->filemanager = new FilemanagerController();
        $this->config = new ConfigController();
        $this->data->web_title = 'Posts';
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
        $this->systemLogs('view', 'posts', $request);
        // End
        if(\Request::get('account_id')!=$this->data->auth_id) {
            return view('errors.504');
        }
        
        $this->data->text_title = trans('text.posts_management');
        $this->data->button_upload = trans('button.upload');
        $this->data->action_list = url('/posts/list');
        $this->data->add_post = url('/posts/create');
        $this->data->action_delete = url('/posts/delete');
        return view('post.index', ['data'=>$this->data]);
    }

    public function getList() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_list', 'posts', $request);
        // End
        $this->data->edit_post = url('/posts/edit');

        // define data filter

        // defind category id
        if(isset($request['category_id']) && $request['country_id']!='0') {
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

        // defind view loading people or posted
        if(isset($request['view'])) {
            $view = $request['view'];
        }else {
            $view = null;
        }

        // defind browse
        if(isset($request['browse'])) {
            $browse = $request['browse'];
        }else {
            $browse = null;
        }

        // defind time
        if(isset($request['time'])) {
            $time = $request['time'];
        }else {
            $time = null;
        }

        // defind alpha
        if(isset($request['alpha'])) {
            $alpha = $request['alpha'];
        }else {
            $alpha = null;
        }

        // defind country id
        if(isset($request['country_id'])) {
            $country_id = $request['country_id'];
        }else {
            $country_id = null;
        }

        // defind zone id
        if(isset($request['zone_id'])) {
            $zone_id = $request['zone_id'];
        }else {
            $zone_id = null;
        }

        // defind sort order
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

        // End

        // define filter data
        $filter_data = array(
            'status' => ['0', '1'],
            'author_id' => $this->data->auth_id,
            'category_id' => $category_id,
            'search'    => $search,
            'browse' => $browse,
            'time' => $time,
            'alpha' => $alpha,
            'country_id' => $country_id,
            'zone_id' => $zone_id,
            'sort'  => $sort,
            'order' => $order
        );

        // define paginate url
        $paginate_url = [
            'status' => ['0', '1'],
            'account_id'=>$this->data->auth_id,
            'category_id'=>$category_id,
            'search' => $search,
            'view' => $view,
            'browse' => $browse,
            'time' => $time,
            'alpha' => $alpha,
            'country_id' => $country_id,
            'zone_id' => $zone_id
        ];
        if (isset($request['sort'])) {
            $paginate_url['sort'] = $request['sort'];
        }

        if (isset($request['order'])) {
            $paginate_url['order'] = $request['order'];
        }

        $this->data->posts = $this->post->getPosts($filter_data)->paginate(10)->setPath(url('/posts'))->appends($paginate_url);

        if(count($this->data->posts) > 0) {
            foreach ($this->data->posts as $post) {
                if (!empty($post->image) && is_file($this->data->dir_image . $post->image)) {

                    if($post->watermark_status=='1') {
                        $user_watermark = $this->user->getWatermarkByUserId($this->data->auth_id);
                        $this->data->thumb[$post->post_id] = $this->filemanager->resizeWithWatermark($post->image, 600, 400, ((isset($user_watermark->image))? $user_watermark->image:'watermark_koktep.png'), ((isset($user_watermark->position))? $user_watermark->position:'center'));
                    }else {
                        $this->data->thumb[$post->post_id] = $this->filemanager->resize($post->image, 600, 400);
                    }
                    
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

        $this->data->delete_confirmation = trans('text.delete_confirmation');
        $this->data->delete_confirmation_message = trans('text.delete_confirmation_message');
        $this->data->show = trans('text.show');
        $this->data->to = trans('text.to');
        $this->data->of = trans('text.of');
        $this->data->page = trans('text.page');
        $this->data->text_rating = trans('text.text_rating');

        $this->data->icon_view = trans('icon.view');
        $this->data->icon_comment = trans('icon.comment');
        $this->data->icon_date = trans('icon.date');

        $this->data->button_edit = trans('button.edit');
        $this->data->button_delete = trans('button.delete');
        $this->data->button_yes = trans('button.yes');
        $this->data->button_no = trans('button.no');

        $this->data->status = $this->status();
        $this->data->post_detail = url('/post-account/detail');
        $this->data->text_empty = '...';

        return view('post.list', ['data' => $this->data]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return Response
     */
    public function getCreate()
    {
        $request = \Request::all();
        // add system log
        $this->systemLogs('create', 'posts', $request);
        // End
        $this->data->text_title = trans('text.posts_management');

        $this->data->button_cancel = trans('button.cancel');
        $this->data->button_save = trans('button.save');

        $this->data->go_back = url('/posts');
        $this->data->action = url('/posts/store');
        $this->data->action_form = url('/posts/create-load-form');
        return view('post.create', ['data'=>$this->data]);
    }

    public function getCreateLoadForm() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_form', 'posts', $request);
        // End
        $datas = [
            'icon' => 'icon_create',
            'titlelist' => trans('button.upload')
        ];
        echo $this->getPostForm($datas);
        exit();
    }

    public function getLoadUploadForm() {
        $this->getCreateLoadForm();
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
        $this->systemLogs('submit_form', 'posts', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $this->data->action_form = url('/posts/create-load-form');

                $validationError = $this->post->validationForm(['request'=>$request, 'action'=>'create']);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // insert post
                $postDatas = [
                    'author_id'     => $this->data->auth_id,
                    'image'         => $this->escape($request['image']),
                    'watermark_status' => $this->escape(((isset($request['watermark']))? $request['watermark']:'0')),
                    'status'        => $this->escape($request['status'])
                ];

                $post = $this->post->create($postDatas);
                // End

                // insert post description
                $post_descriptionDatas = [
                    'post_id'       => $post->id,
                    'post_description_datas'    => ((isset($request['post_description']))? $request['post_description']:[])
                ];

                $post_description = $this->post->insertPostDescription($post_descriptionDatas);
                // End

                // insert post to layout
                $post_to_layoutDatas['post_to_layout_datas'][] = [
                    'post_id'       => $post->id,
                    'website_id'    => '1',
                    'layout_id'     => '0'
                ];

                $post_to_layout = $this->post->insertPostToLayout($post_to_layoutDatas);
                // End

                // insert post to categories
                $post_to_categoryDatas = [
                    'post_id'       => $post->id,
                    'post_category_datas'   => ((isset($request['post_category']))? $request['post_category']:[])
                ];

                $post_category = $this->post->insertPostCategory($post_to_categoryDatas);
                // End

                // insert post image
                $post_imageDatas = [
                    'post_id'       => $post->id,
                    'post_images'   => ((isset($request['post_image']))? $request['post_image']:[])
                ];

                $post_category = $this->post->insertPostImage($post_imageDatas);
                // End

                // insert post image
                $post_relatedDatas = [
                    'post_id'       => $post->id,
                    'posts_related' => ((isset($request['post_related']))? $request['post_related']:[])
                ];

                $post_category = $this->post->insertPostRelated($post_relatedDatas);
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
    public function getEdit($post_id)
    {
        $request = \Request::all();
        // add system log
        $this->systemLogs('edit', 'posts', $request);
        // End

        $this->data->text_title = trans('text.posts_management');

        $this->data->button_cancel = trans('button.cancel');
        $this->data->button_save_change = trans('button.save_change');

        $this->data->go_back = url('/posts');
        $this->data->action  = url('/posts/update/'.$post_id);
        $this->data->action_form = url('/posts/edit-load-form/'.$post_id);
        return view('post.edit', ['data'=>$this->data]);
    }

    public function getEditLoadForm($post_id) {
        $request = \Request::all();
        // add system log
        $this->systemLogs('load_form', 'posts', $request);
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

        $this->data->post = $this->post->getPost($post_id);
        $this->data->post_descriptions = $this->post->getPostDescriptions($post_id);

        $post_to_categories = $this->post->getPostCategories($post_id);
        $data['post_categories'] = [];

        foreach ($post_to_categories as $post_to_category) {
            $category_info = $this->category->getCategory($post_to_category->category_id, $language_id);

            if ($category_info) {
                $data['post_categories'][] = [
                    'category_id' => $category_info->category_id,
                    'name' => ($category_info->path) ? $category_info->path . ' &gt; ' . $category_info->name : $category_info->name
                ];
            }
        }

        $post_relateds = $this->post->getPostRelated($post_id);
        $data['post_relateds'] = [];
        foreach ($post_relateds as $value_post_id) {
            $related_info = $this->post->getPost($value_post_id);

            if ($related_info) {
                $data['post_relateds'][] = [
                    'post_id' => $related_info->post_id,
                    'title'       => $related_info->title
                ];
            }
        }

        $post_images = $this->post->getPostImages($post_id);
        $data['post_images'] = [];

        foreach ($post_images as $post_image) {
            if (is_file($this->data->dir_image . $post_image->image)) {
                $image = $post_image->image;
                $thumb = $post_image->image;
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $data['post_images'][] = [
                'image'      => $image,
                'thumb'      => $this->filemanager->resize($thumb, 120, 80),
                'watermark_status' => $post_image->watermark_status,
                'sort_order' => $post_image->sort_order
            ];
        }

        $datas = [
            'icon' => 'icon_edit',
            'titlelist' => trans('button.edit'),
            'post' => $this->data->post,
            'post_descriptions' => $this->data->post_descriptions,
            'post_to_categories' => $data['post_categories'],
            'post_relateds' => $data['post_relateds'],
            'post_images'    => $data['post_images']
        ];

        echo $this->getPostForm($datas);
        exit();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postUpdate($post_id)
    {
        $request = \Request::all();

        // add system log
        $this->systemLogs('submit_form', 'posts', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $validationError = $this->post->validationForm(['request'=>$request, 'action'=>'edit']);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // update post
                $postDatas = [
                    'updated_by_author_id'  => $this->data->auth_id,
                    'image'         => $this->escape($request['image']),
                    'watermark_status' => $this->escape(((isset($request['watermark']))? $request['watermark']:'0')),
                    'status'        => $this->escape($request['status'])
                ];
                $post = $this->post->where('post_id', '=', $post_id)->update($postDatas);
                // End

                // update post description
                $clear_post_description = $this->post->deletedPostDescription($post_id);
                $post_descriptionDatas = [
                    'post_id'       => $post_id,
                    'post_description_datas'    => ((isset($request['post_description']))? $request['post_description']:[])
                ];

                $post_description = $this->post->insertPostDescription($post_descriptionDatas);
                // End

                // update post to layout
                $clear_post_to_layout = $this->post->deletedPostToLayout($post_id);
                $post_to_layoutDatas['post_to_layout_datas'][] = [
                    'post_id'       => $post_id,
                    'website_id'    => '1',
                    'layout_id'     => '0'
                ];

                $post_to_layout = $this->post->insertPostToLayout($post_to_layoutDatas);
                // End

                // update post to categories
                $clear_post_to_category = $this->post->deletedPostToCategory($post_id);
                $post_to_categoryDatas = [
                    'post_id'       => $post_id,
                    'post_category_datas'   => ((isset($request['post_category']))? $request['post_category']:[])
                ];

                $post_category = $this->post->insertPostCategory($post_to_categoryDatas);
                // End

                // update post image
                $clear_post_image = $this->post->deletedPostImage($post_id);
                $post_imageDatas = [
                    'post_id'       => $post_id,
                    'post_images'   => ((isset($request['post_image']))? $request['post_image']:[])
                ];

                $post_category = $this->post->insertPostImage($post_imageDatas);
                // End

                // update post related
                $clear_post_related = $this->post->deletedPostRelated($post_id);
                $post_relatedDatas = [
                    'post_id'       => $post_id,
                    'posts_related' => ((isset($request['post_related']))? $request['post_related']:[])
                ];

                $post_category = $this->post->insertPostRelated($post_relatedDatas);
                // End

                // remove image from diractory
                $old_image = $request['image'];
                $extension = pathinfo($old_image, PATHINFO_EXTENSION);
                $new_image = 'cache/' . substr($old_image, 0, strrpos($old_image, '.')) . '-' . 600 . 'x' . 400 . '.' . $extension;
                $pathImage = rtrim($this->data->dir_image . str_replace(array('../', '..\\', '..'), '', $this->escape($new_image)), '/');

                // If path is just a file delete it
                if (is_file($pathImage)) {
                    unlink($pathImage);
                }

                if(isset($request['post_image'])) {
                    foreach ($request['post_image'] as $post_image) {
                        // remove image from diractory
                        $old_image = $post_image['image'];
                        $extension = pathinfo($old_image, PATHINFO_EXTENSION);
                        $new_image = 'cache/' . substr($old_image, 0, strrpos($old_image, '.')) . '-' . 600 . 'x' . 400 . '.' . $extension;
                        $pathImage = rtrim($this->data->dir_image . str_replace(array('../', '..\\', '..'), '', $this->escape($new_image)), '/');

                        // If path is just a file delete it
                        if (is_file($pathImage)) {
                            unlink($pathImage);
                        }
                    }
                }

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

    public function getPostForm($datas=[]) {
        $this->data->go_category_autocomplete = url('/category/autocomplete');
        $this->data->go_related_autocomplete = url('/posts/autocomplete');
        $this->data->languages = $this->language->getLanguages(['sort'=>'name', 'order'=>'asc'])->get();
        $this->data->watermark = $this->user->getWatermarkByUserId($this->data->auth_id);
        $this->data->layouts = $this->layout->orderBy('name', 'asc')->lists('name', 'layout_id');
        $this->data->status = $this->status();

        if($this->data->watermark || isset($datas['post'])) {

            if(isset($datas['post'])) {
                $this->data->watermark_status = $datas['post']->watermark_status;
            } else {
                $this->data->watermark_status = $this->data->watermark->status;
            }

        }else {
            $this->data->watermark_status = '0';
        }

        // define tap
        $this->data->tab_general = trans('text.tab_general');
        $this->data->tab_data = trans('text.tab_data');
        $this->data->tab_links = trans('text.tab_links');
        $this->data->tab_design = trans('text.tab_design');
        $this->data->tab_image = trans('text.tab_image');

        // define entry
        $this->data->entry_title = trans('text.entry_title');
        $this->data->entry_description = trans('text.entry_description');
        $this->data->entry_meta_title = trans('text.entry_meta_title');
        $this->data->entry_meta_description = trans('text.entry_meta_description');
        $this->data->entry_meta_keyword = trans('text.entry_meta_keyword');
        $this->data->entry_tag = trans('text.entry_tag');


        $this->data->entry_keyword = trans('text.entry_keyword');
        $this->data->entry_image = trans('text.entry_image');
        $this->data->entry_watermark = trans('text.entry_watermark');
        $this->data->entry_status = trans('text.entry_status');
        $this->data->entry_sort_order = trans('text.entry_sort_order');

        $this->data->entry_category = trans('text.entry_category');
        $this->data->entry_related = trans('text.entry_related');

        $this->data->entry_layout = trans('text.entry_layout');

        // define input title
        $this->data->title_tags = trans('text.title_tags');
        $this->data->title_keyword = trans('text.title_keyword');
        $this->data->title_category = trans('text.autocomplete');
        $this->data->title_related = trans('text.autocomplete');
        $this->data->title_watermark = trans('text.title_watermark');

        $this->data->text_none = trans('text.none');

        $this->data->button_remove = trans('button.remove');
        $this->data->button_image_add = trans('button.image_add');

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
                $this->data->post_description[$description->language_id]['title'] = $description->title;
                $this->data->post_description[$description->language_id]['description'] = $description->description;
                $this->data->post_description[$description->language_id]['tag'] = $description->tag;
            }
        }else {
            foreach ($this->data->languages as $language) {
                $this->data->post_description[$language->language_id]['title'] = '';
                $this->data->post_description[$language->language_id]['description'] = '';
                $this->data->post_description[$language->language_id]['tag'] = '';
            }
        }

        if(isset($datas['post_to_categories'])) {
            $this->data->post_categories = $datas['post_to_categories'];
        }else {
            $this->data->post_categories = [];
        }

        if(isset($datas['post_relateds'])) {
            $this->data->post_relateds = $datas['post_relateds'];
        }else {
            $this->data->post_relateds = [];
        }

        if(isset($datas['post_images'])) {
            $this->data->post_images = $datas['post_images'];
        }else {
            $this->data->post_images = [];
        } 

        if ($this->data->image && is_file($this->data->dir_image . $this->data->image)) {
            $this->data->thumb = $this->filemanager->resize($this->data->image, 120, 80);
        } else {
            $this->data->thumb = $this->filemanager->resize('no_image.png', 120, 80);
        }

        $this->data->placeholder = $this->filemanager->resize('no_image.png', 120, 80);

        $this->data->titlelist = (($datas['titlelist'])? $datas['titlelist']:'');
        $this->data->icon = (($datas['icon'])? $datas['icon']:'');

        return view('post.form', ['data' => $this->data]);
    }

    public function postDelete() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('delete', 'posts', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $post = $this->post->where('post_id', '=', $request['post_id'])->first();
                if($post) {
                    $request['post_invalid'] = 'true';
                    $request['post_author_id'] = $post->author_id;
                }else {
                    $request['post_invalid'] = '';
                    $request['post_author_id'] = '0';
                }
                
                $request['author_id'] = $this->data->auth_id;
                $this->data->action_list = url('/posts/list');

                $validationError = $this->post->validationDeleteForm(['request'=>$request, 'action'=>'delete']);
                if($validationError) {
                    return \Response::json($validationError);
                }

                // delete old post by update status to 300
                $this->post->where('post_id', '=', $request['post_id'])->update(['status'=>'300']);
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

    public function postComment() {
        $request = \Request::all();
        // add system log
        $this->systemLogs('submit_form', 'posts', $request);
        // End
        if(\Request::ajax()) {
            DB::beginTransaction();
            try {

                $validationError = $this->post->validationCommentForm(['request'=>$request]);
                if($validationError) {
                    return \Response::json($validationError);
                }

                $this->data->action_form = url('/post-account/comment-form?post_id='.$request['post_id']);
                $this->data->action_load_rating = url('/post-account/load-rating?post_id='.$request['post_id']);

                if(\Request::has('comment')) {
                    // insert post comment
                    $postCommentDatas = [
                        'user_id'     => $this->data->auth_id,
                        'post_id'     => $request['post_id'],
                        'comment'     => $this->escape($request['comment']),
                        'rating'      => ((isset($request['rating']))? $request['rating']:0),
                        'parent_id'   => '0'
                    ];

                    $post_comment = $this->post_comment->create($postCommentDatas);
                    // End
                }

                DB::commit();
                $return = ['error'=>'0','success'=>'1','action'=>'create','msg'=>trans('text.success_comment'), 'load_form'=>$this->data->action_form, 'load_rating'=>$this->data->action_load_rating, 'display_id'=>'load-rating'];
                return \Response::json($return);
            } catch (Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                exit();
            }
        }
        exit();
    }

    public function getAutocomplete() {
        $request = \Request::all();
        $json = [];

        if (isset($request['filter_title'])) {

            if(isset($request['filter_view'])&&$request['filter_view']=='people') {
                $filter_data = [
                    'filter_title' => $request['filter_title'],
                    'sort'        => 'name',
                    'order'       => 'ASC',
                    'start'       => 0,
                    'limit'       => 5
                ];

                $results = $this->user->getAutocompleteUsers($filter_data);
                foreach ($results as $result) {
                    $json[] = [
                        'user_id' => $result->user_id,
                        'title'   => strip_tags(html_entity_decode($result->name, ENT_QUOTES, 'UTF-8'))
                    ];
                }

            }else {
                $filter_data = [
                    'filter_title' => $request['filter_title'],
                    'sort'        => 'title',
                    'order'       => 'ASC',
                    'start'       => 0,
                    'limit'       => 5
                ];

                $results = $this->post->getAutocompletePosts($filter_data);

                foreach ($results as $result) {
                    $json[] = [
                        'post_id' => $result->post_id,
                        'title'   => strip_tags(html_entity_decode($result->title, ENT_QUOTES, 'UTF-8'))
                    ];
                }
            }
        }

        $sort_order = [];

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['title'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        return json_encode($json);
    }

}
